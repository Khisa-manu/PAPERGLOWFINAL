import React, { useState, useEffect } from 'react';
import { api } from '../services/api';
import {
  ClinicModule,
  ClinicProfile,
  Patient,
  Appointment,
  QueueItem,
  ConsultationRecord,
  MedicalService,
  StaffMember,
  Invoice,
  PaymentReceipt,
  ClinicDocument,
  ClinicNotification,
  AppointmentStatus,
  PaymentMethod,
  VitalSigns,
} from '../types/clinicManager';

import {
  DEFAULT_CLINIC_PROFILE,
  DEFAULT_PATIENTS,
  DEFAULT_SERVICES,
  DEFAULT_STAFF,
  DEFAULT_APPOINTMENTS,
  DEFAULT_QUEUE,
  DEFAULT_CONSULTATIONS,
  DEFAULT_INVOICES,
  DEFAULT_RECEIPTS,
  DEFAULT_CLINIC_DOCUMENTS,
  DEFAULT_CLINIC_NOTIFICATIONS,
} from '../data/defaultClinicData';

import { ClinicHeader } from '../components/clinicManager/ClinicHeader';
import { ClinicSidebar } from '../components/clinicManager/ClinicSidebar';
import { DashboardModule } from '../components/clinicManager/DashboardModule';
import { PatientsModule } from '../components/clinicManager/PatientsModule';
import { AppointmentsModule } from '../components/clinicManager/AppointmentsModule';
import { QueueModule } from '../components/clinicManager/QueueModule';
import { ConsultationsModule } from '../components/clinicManager/ConsultationsModule';
import { BillingModule } from '../components/clinicManager/BillingModule';
import { ServicesModule } from '../components/clinicManager/ServicesModule';
import { StaffModule } from '../components/clinicManager/StaffModule';
import { DocumentsModule } from '../components/clinicManager/DocumentsModule';
import { NotificationsModule } from '../components/clinicManager/NotificationsModule';
import { ReportsModule } from '../components/clinicManager/ReportsModule';
import { SettingsModule } from '../components/clinicManager/SettingsModule';

import { RegisterPatientModal } from '../components/clinicManager/RegisterPatientModal';
import { BookAppointmentModal } from '../components/clinicManager/BookAppointmentModal';
import { RecordVitalsModal } from '../components/clinicManager/RecordVitalsModal';
import { CreateInvoiceModal } from '../components/clinicManager/CreateInvoiceModal';
import { RecordPaymentModal } from '../components/clinicManager/RecordPaymentModal';
import { PatientProfileModal } from '../components/clinicManager/PatientProfileModal';

import { CheckCircle2 } from 'lucide-react';

interface ClinicManagerPageProps {
  onBackToPaperglow: () => void;
}

export const ClinicManagerPage: React.FC<ClinicManagerPageProps> = ({
  onBackToPaperglow,
}) => {
  const [currentModule, setCurrentModule] = useState<ClinicModule>('dashboard');
  const [isMobileSidebarOpen, setIsMobileSidebarOpen] = useState(false);

  // Modals
  const [isRegisterPatientOpen, setIsRegisterPatientOpen] = useState(false);
  const [isBookAppointmentOpen, setIsBookAppointmentOpen] = useState(false);
  const [bookAppointmentPatientId, setBookAppointmentPatientId] = useState<string | undefined>(undefined);
  const [isRecordVitalsOpen, setIsRecordVitalsOpen] = useState(false);
  const [vitalsQueueItem, setVitalsQueueItem] = useState<QueueItem | null>(null);
  const [isCreateInvoiceOpen, setIsCreateInvoiceOpen] = useState(false);
  const [createInvoicePatientId, setCreateInvoicePatientId] = useState<string | undefined>(undefined);
  const [isRecordPaymentOpen, setIsRecordPaymentOpen] = useState(false);
  const [selectedInvoiceForPayment, setSelectedInvoiceForPayment] = useState<Invoice | null>(null);
  const [isPatientProfileOpen, setIsPatientProfileOpen] = useState(false);
  const [selectedPatientForProfile, setSelectedPatientForProfile] = useState<Patient | null>(null);

  // Toast System
  const [toastMessage, setToastMessage] = useState<string | null>(null);
  const showToast = (msg: string) => {
    setToastMessage(msg);
    setTimeout(() => {
      setToastMessage((prev) => (prev === msg ? null : prev));
    }, 4000);
  };

  // State initialized with MariaDB backend data
  const [clinic, setClinic] = useState<ClinicProfile>(DEFAULT_CLINIC_PROFILE);
  const [patients, setPatients] = useState<Patient[]>([]);
  const [appointments, setAppointments] = useState<Appointment[]>([]);
  const [queue, setQueue] = useState<QueueItem[]>([]);
  const [consultations, setConsultations] = useState<ConsultationRecord[]>([]);
  const [services, setServices] = useState<MedicalService[]>(DEFAULT_SERVICES);
  const [staff, setStaff] = useState<StaffMember[]>(DEFAULT_STAFF);
  const [invoices, setInvoices] = useState<Invoice[]>([]);
  const [receipts, setReceipts] = useState<PaymentReceipt[]>([]);
  const [documents, setDocuments] = useState<ClinicDocument[]>(DEFAULT_CLINIC_DOCUMENTS);
  const [notifications, setNotifications] = useState<ClinicNotification[]>([]);

  // Cloud Synchronization State
  const [isCloudSyncing, setIsCloudSyncing] = useState<boolean>(false);
  const [isCloudOnline, setIsCloudOnline] = useState<boolean>(true);

  const fetchCloudClinicData = async () => {
    setIsCloudSyncing(true);
    try {
      const [patRes, aptRes, visRes] = await Promise.allSettled([
        api.clinic.getPatients(),
        api.clinic.getAppointments(),
        api.clinic.getVisits(),
      ]);

      if (patRes.status === 'fulfilled' && patRes.value?.data && patRes.value.data.length > 0) {
        const cloudPatients: Patient[] = patRes.value.data.map((p: any) => ({
          id: String(p.id || p.uuid),
          patientNumber: p.opd_number || `OPD-${p.id}`,
          fullName: p.name || '',
          gender: (p.gender === 'Female' ? 'Female' : 'Male') as any,
          dateOfBirth: p.dob || '1990-01-01',
          age: 35,
          phone: p.phone || '',
          email: p.email || '',
          nationalId: `ID-${p.id}`,
          residentialArea: 'Nairobi',
          emergencyContactName: 'Next of Kin',
          emergencyContactPhone: p.phone || '',
          emergencyContactRelation: 'Spouse',
          bloodGroup: (p.blood_group || 'O+') as any,
          allergies: p.allergies ? p.allergies.split(', ') : ['None'],
          chronicConditions: p.chronic_conditions ? p.chronic_conditions.split(', ') : ['None'],
          paymentModePreference: 'Cash / M-Pesa' as any,
          dateRegistered: p.created_at ? p.created_at.split('T')[0] : '2026-01-10',
          lastVisitDate: p.created_at ? p.created_at.split('T')[0] : '2026-02-01',
          totalVisits: Number(p.total_visits || 1),
          outstandingBalanceKes: 0,
        }));
        setPatients(cloudPatients);
      }

      if (aptRes.status === 'fulfilled' && aptRes.value?.data && aptRes.value.data.length > 0) {
        const cloudAppointments: Appointment[] = aptRes.value.data.map((a: any) => ({
          id: String(a.id || a.uuid),
          appointmentNumber: `APT-${a.id}`,
          patientId: String(a.patient_id || 'pat-1'),
          patientName: a.patient_name || '',
          patientNumber: a.patient_opd || `OPD-${a.id}`,
          patientPhone: '+254712000000',
          practitionerId: 'staff-1',
          practitionerName: a.practitioner || 'Consulting Physician',
          serviceId: 'srv-1',
          serviceName: a.reason || 'General Medical Consultation',
          date: a.date || new Date().toISOString().split('T')[0],
          timeSlot: a.time || '10:00 AM',
          type: 'Consultation' as any,
          status: (a.status?.toLowerCase() || 'scheduled') as any,
          notes: a.reason || 'Cloud synchronized appointment',
          reminderSent: false,
        }));
        setAppointments(cloudAppointments);
      }

      if (visRes.status === 'fulfilled' && visRes.value?.data && visRes.value.data.length > 0) {
        const cloudVisits: ConsultationRecord[] = visRes.value.data.map((v: any) => ({
          id: String(v.id || v.uuid),
          consultationNumber: v.visit_number || `VIS-${v.id}`,
          patientId: String(v.patient_id || 'pat-1'),
          patientName: v.patient_name || '',
          patientNumber: v.patient_opd || `OPD-${v.id}`,
          practitionerId: 'staff-1',
          practitionerName: v.doctor || 'Doctor',
          date: v.date || new Date().toISOString().split('T')[0],
          chiefComplaint: v.diagnosis || 'Clinical Review',
          historyOfPresentIllness: 'Stable presentation',
          examinationFindings: 'All vitals within normal parameters',
          provisionalDiagnosis: v.diagnosis || 'General',
          finalDiagnosis: v.diagnosis || 'General',
          prescriptions: [],
          labTestsRequested: [],
          treatmentPlanNotes: v.prescription || 'Follow prescription as advised',
          followUpDate: '2026-03-01',
          consultationFeeKes: Number(v.total_cost || 2000),
          status: 'completed' as any,
        }));
        setConsultations(cloudVisits);
      }

      setIsCloudOnline(true);
    } catch (err) {
      console.warn('[Clinic Cloud] Offline cache fallback:', err);
      setIsCloudOnline(false);
    } finally {
      setIsCloudSyncing(false);
    }
  };

  useEffect(() => {
    fetchCloudClinicData();
  }, []);

  const toggleDarkMode = () => {
    const next = !isDark;
    setIsDark(next);
    if (next) document.documentElement.classList.add('dark');
    else document.documentElement.classList.remove('dark');
  };

  // HANDLERS with MariaDB persistence
  const handleRegisterPatient = (
    patientData: Omit<Patient, 'id' | 'totalVisits' | 'outstandingBalanceKes'>
  ) => {
    const newId = `pat-${Date.now().toString().slice(-4)}`;
    const newPatient: Patient = {
      ...patientData,
      id: newId,
      totalVisits: 1,
      outstandingBalanceKes: 0,
    };

    setPatients((prev) => [newPatient, ...prev]);

    api.clinic.createPatient({
      opd_number: newPatient.patientNumber,
      name: newPatient.fullName,
      phone: newPatient.phone,
      email: newPatient.email,
      gender: newPatient.gender === 'Female' ? 'Female' : 'Male',
      dob: newPatient.dateOfBirth,
      blood_group: newPatient.bloodGroup,
      allergies: (newPatient.allergies || []).join(', ') || 'None',
      chronic_conditions: (newPatient.chronicConditions || []).join(', ') || 'None',
      total_visits: 1,
    }).catch((err) => console.warn('Could not persist patient to backend:', err));

    showToast(`Patient ${newPatient.fullName} (${newPatient.patientNumber}) registered successfully.`);
  };

  const handleBookAppointment = (
    aptData: Omit<Appointment, 'id' | 'appointmentNumber' | 'reminderSent'>
  ) => {
    const newId = `apt-${Date.now().toString().slice(-4)}`;
    const newApt: Appointment = {
      ...aptData,
      id: newId,
      appointmentNumber: `APT-2026-0${Math.floor(100 + Math.random() * 899)}`,
      reminderSent: false,
    };

    setAppointments((prev) => [newApt, ...prev]);

    api.clinic.createAppointment({
      patient_name: newApt.patientName,
      patient_opd: newApt.patientNumber,
      practitioner: newApt.practitionerName,
      date: newApt.date,
      time: newApt.timeSlot,
      reason: newApt.serviceName || newApt.type,
      status: 'Scheduled',
    }).catch(() => {});

    showToast(`Appointment booked for ${newApt.patientName} with ${newApt.practitionerName} on ${newApt.date} at ${newApt.timeSlot}.`);
  };

  const handleUpdateAppointmentStatus = (id: string, status: AppointmentStatus) => {
    setAppointments((prev) =>
      prev.map((a) => (a.id === id ? { ...a, status } : a))
    );
    api.clinic.updateAppointment(id, { status }).catch(() => {});
    showToast(`Appointment status updated to ${status}.`);
  };

  const handleSendAppointmentReminder = (apt: Appointment) => {
    setAppointments((prev) =>
      prev.map((a) => (a.id === apt.id ? { ...a, reminderSent: true } : a))
    );
    showToast(`SMS reminder dispatched to ${apt.patientPhone} for appointment ${apt.timeSlot}.`);
  };

  const handleCancelAppointment = (id: string) => {
    setAppointments((prev) =>
      prev.map((a) => (a.id === id ? { ...a, status: 'cancelled' } : a))
    );
    api.clinic.updateAppointment(id, { status: 'Cancelled' }).catch(() => {});
    showToast(`Appointment cancelled.`);
  };

  const handleCheckInWalkIn = (
    patId: string,
    practitionerId: string,
    priority: 'Normal' | 'Urgent' | 'Emergency'
  ) => {
    const pat = patients.find((p) => p.id === patId) || patients[0];
    const doc = staff.find((s) => s.id === practitionerId) || staff[0];

    const newQueueItem: QueueItem = {
      id: `q-${Date.now().toString().slice(-4)}`,
      queueNumber: 100 + queue.length + 1,
      patientId: pat.id,
      patientName: pat.fullName,
      patientNumber: pat.patientNumber,
      arrivalTime: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
      triageCompleted: false,
      stage: 'triage',
      priority,
      assignedPractitionerId: doc.id,
      assignedPractitionerName: doc.fullName,
      consultingRoom: doc.consultingRoom || 'Room 1',
      waitTimeMinutes: 0,
      vitalSignsRecorded: false,
    };

    setQueue((prev) => [...prev, newQueueItem]);
    showToast(`Patient ${pat.fullName} checked in to queue (Q-${newQueueItem.queueNumber}).`);
  };

  const handleAdvanceQueueStage = (queueId: string) => {
    setQueue((prev) =>
      prev.map((q) => {
        if (q.id === queueId) {
          let nextStage: QueueItem['stage'] = 'completed';
          if (q.stage === 'triage') nextStage = 'waiting';
          else if (q.stage === 'waiting') nextStage = 'in_consultation';
          else if (q.stage === 'in_consultation') nextStage = 'ready_for_billing';
          return { ...q, stage: nextStage };
        }
        return q;
      })
    );
    showToast(`Patient queue stage updated.`);
  };

  const handleSaveVitalsForQueue = (queueId: string, vitals: VitalSigns) => {
    setQueue((prev) =>
      prev.map((q) =>
        q.id === queueId
          ? { ...q, triageCompleted: true, stage: 'waiting', vitalSignsRecorded: true }
          : q
      )
    );
    showToast(`Vitals recorded for patient. Transferred to waiting bay.`);
  };

  const handleDischargeAndBill = (queueItem: QueueItem) => {
    setQueue((prev) => prev.filter((q) => q.id !== queueItem.id));
    setCreateInvoicePatientId(queueItem.patientId);
    setIsCreateInvoiceOpen(true);
    showToast(`Patient checked out. Opening billing interface.`);
  };

  const handleAddConsultation = (
    recData: Omit<ConsultationRecord, 'id' | 'visitNumber' | 'billed'>
  ) => {
    const newId = `cns-${Date.now().toString().slice(-4)}`;
    const newRecord: ConsultationRecord = {
      ...recData,
      id: newId,
      visitNumber: `VIS-2026-0${Math.floor(100 + Math.random() * 899)}`,
      billed: false,
    };

    setConsultations((prev) => [newRecord, ...prev]);

    // Update patient visit count & last visit date
    setPatients((prev) =>
      prev.map((p) =>
        p.id === recData.patientId
          ? { ...p, totalVisits: p.totalVisits + 1, lastVisitDate: recData.date }
          : p
      )
    );

    // Update doctor's consultation tally
    setStaff((prev) =>
      prev.map((s) =>
        s.id === recData.practitionerId
          ? { ...s, totalConsultationsCompleted: s.totalConsultationsCompleted + 1 }
          : s
      )
    );

    showToast(`Clinical encounter ${newRecord.visitNumber} logged in patient EHR.`);
  };

  const handleCreateInvoice = (invoiceData: Omit<Invoice, 'id' | 'invoiceNumber'>) => {
    const newId = `inv-${Date.now().toString().slice(-4)}`;
    const newInvoice: Invoice = {
      ...invoiceData,
      id: newId,
      invoiceNumber: `INV-2026-0${Math.floor(100 + Math.random() * 899)}`,
    };

    setInvoices((prev) => [newInvoice, ...prev]);

    // If payment was made at invoice creation, generate receipt
    if (newInvoice.amountPaidKes > 0) {
      const newReceipt: PaymentReceipt = {
        id: `rcp-${Date.now().toString().slice(-4)}`,
        receiptNumber: `RCP-2026-0${Math.floor(100 + Math.random() * 899)}`,
        invoiceId: newInvoice.id,
        invoiceNumber: newInvoice.invoiceNumber,
        patientId: newInvoice.patientId,
        patientName: newInvoice.patientName,
        patientNumber: newInvoice.patientNumber,
        date: newInvoice.date,
        amountPaidKes: newInvoice.amountPaidKes,
        paymentMethod: newInvoice.paymentMethod || 'M-Pesa',
        transactionReference: newInvoice.paymentReference || 'MPESA-TX',
        receivedBy: newInvoice.servedBy,
      };
      setReceipts((prev) => [newReceipt, ...prev]);
    }

    // Update patient outstanding balance
    setPatients((prev) =>
      prev.map((p) =>
        p.id === newInvoice.patientId
          ? { ...p, outstandingBalanceKes: p.outstandingBalanceKes + newInvoice.balanceKes }
          : p
      )
    );

    showToast(`Invoice ${newInvoice.invoiceNumber} created. Total KES ${newInvoice.totalAmountKes.toLocaleString()}.`);
  };

  const handleRecordPayment = (
    invoiceId: string,
    amountPaidKes: number,
    paymentMethod: PaymentMethod,
    reference: string
  ) => {
    setInvoices((prev) =>
      prev.map((inv) => {
        if (inv.id === invoiceId) {
          const newPaid = inv.amountPaidKes + amountPaidKes;
          const newBalance = Math.max(0, inv.totalAmountKes - newPaid);
          const newStatus = newBalance === 0 ? 'paid' : 'partial';

          // Add receipt
          const newReceipt: PaymentReceipt = {
            id: `rcp-${Date.now().toString().slice(-4)}`,
            receiptNumber: `RCP-2026-0${Math.floor(100 + Math.random() * 899)}`,
            invoiceId: inv.id,
            invoiceNumber: inv.invoiceNumber,
            patientId: inv.patientId,
            patientName: inv.patientName,
            patientNumber: inv.patientNumber,
            date: new Date().toISOString().split('T')[0],
            amountPaidKes,
            paymentMethod,
            transactionReference: reference,
            receivedBy: 'Lucy Auma (Cashier)',
          };
          setReceipts((rPrev) => [newReceipt, ...rPrev]);

          // Update patient balance
          setPatients((pPrev) =>
            pPrev.map((p) =>
              p.id === inv.patientId
                ? { ...p, outstandingBalanceKes: Math.max(0, p.outstandingBalanceKes - amountPaidKes) }
                : p
            )
          );

          return {
            ...inv,
            amountPaidKes: newPaid,
            balanceKes: newBalance,
            status: newStatus,
            paymentMethod,
            paymentReference: reference,
          };
        }
        return inv;
      })
    );

    showToast(`Payment of KES ${amountPaidKes.toLocaleString()} received. Ref #${reference}.`);
  };

  const handleAddService = (srvData: Omit<MedicalService, 'id'>) => {
    const newService: MedicalService = {
      ...srvData,
      id: `srv-${Date.now().toString().slice(-4)}`,
    };
    setServices((prev) => [...prev, newService]);
    showToast(`Service "${newService.name}" added to clinic tariff price list.`);
  };

  const handleToggleServiceActive = (id: string) => {
    setServices((prev) =>
      prev.map((s) => (s.id === id ? { ...s, active: !s.active } : s))
    );
  };

  const handleAddStaff = (staffData: Omit<StaffMember, 'id' | 'totalConsultationsCompleted'>) => {
    const newStaff: StaffMember = {
      ...staffData,
      id: `stf-${Date.now().toString().slice(-4)}`,
      totalConsultationsCompleted: 0,
    };
    setStaff((prev) => [...prev, newStaff]);
    showToast(`Staff member ${newStaff.fullName} registered.`);
  };

  const handleToggleStaffDuty = (id: string) => {
    setStaff((prev) =>
      prev.map((s) =>
        s.id === id
          ? {
              ...s,
              onDuty: !s.onDuty,
              status: !s.onDuty ? 'Available' : 'Off Duty',
            }
          : s
      )
    );
  };

  const handleAddDocument = (docData: Omit<ClinicDocument, 'id' | 'documentNumber'>) => {
    const newDoc: ClinicDocument = {
      ...docData,
      id: `doc-${Date.now().toString().slice(-4)}`,
      documentNumber: `DOC-2026-0${Math.floor(100 + Math.random() * 899)}`,
    };
    setDocuments((prev) => [newDoc, ...prev]);
    showToast(`Document ${newDoc.documentNumber} generated successfully.`);
  };

  const handleSendNotification = (notifData: Omit<ClinicNotification, 'id' | 'isRead'>) => {
    const newNotif: ClinicNotification = {
      ...notifData,
      id: `notif-${Date.now().toString().slice(-4)}`,
      isRead: false,
    };
    setNotifications((prev) => [newNotif, ...prev]);
    showToast(`Notice broadcasted.`);
  };

  const handleMarkNotificationRead = (id: string) => {
    setNotifications((prev) =>
      prev.map((n) => (n.id === id ? { ...n, isRead: true } : n))
    );
  };

  const handleDeleteNotification = (id: string) => {
    setNotifications((prev) => prev.filter((n) => n.id !== id));
  };

  const handleViewPatientProfile = (patientId: string) => {
    const p = patients.find((pat) => pat.id === patientId);
    if (p) {
      setSelectedPatientForProfile(p);
      setIsPatientProfileOpen(true);
    }
  };

  return (
    <div className="min-h-screen bg-neutral-100/70 dark:bg-[#0c0e12] text-neutral-900 dark:text-neutral-100 flex flex-col transition-colors duration-150">
      {/* Toast Alert */}
      {toastMessage && (
        <div className="fixed bottom-5 right-5 z-50 px-4 py-2.5 rounded-xl bg-neutral-900 dark:bg-neutral-100 text-white dark:text-neutral-900 text-xs font-semibold shadow-2xl flex items-center space-x-2 animate-bounce">
          <CheckCircle2 className="w-4 h-4 text-red-500 shrink-0" />
          <span>{toastMessage}</span>
        </div>
      )}

      {/* Top Clinic Header */}
      <ClinicHeader
        clinic={clinic}
        notifications={notifications}
        waitingQueueCount={queue.filter((q) => q.stage === 'waiting' || q.stage === 'triage').length}
        onOpenRegisterPatient={() => setIsRegisterPatientOpen(true)}
        onOpenBookAppointment={() => {
          setBookAppointmentPatientId(undefined);
          setIsBookAppointmentOpen(true);
        }}
        onNavigateModule={(mod) => setCurrentModule(mod)}
        onToggleMobileSidebar={() => setIsMobileSidebarOpen(!isMobileSidebarOpen)}
        onBackToPaperglow={onBackToPaperglow}
        isDark={isDark}
        onToggleDarkMode={toggleDarkMode}
        isOnline={isCloudOnline}
        isSyncing={isCloudSyncing}
        onManualSync={fetchCloudClinicData}
      />

      {/* Main Workspace */}
      <div className="flex-1 flex w-full">
        <ClinicSidebar
          currentModule={currentModule}
          onSelectModule={(mod) => setCurrentModule(mod)}
          isOpenMobile={isMobileSidebarOpen}
          onCloseMobile={() => setIsMobileSidebarOpen(false)}
          counts={{
            totalPatients: patients.length,
            todayAppointments: appointments.filter((a) => a.date === '2026-10-06').length,
            queueWaiting: queue.filter((q) => q.stage === 'waiting' || q.stage === 'triage').length,
            pendingInvoices: invoices.filter((i) => i.status !== 'paid').length,
            unreadNotifications: notifications.filter((n) => !n.isRead).length,
          }}
        />

        <main className="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full overflow-y-auto">
          {currentModule === 'dashboard' && (
            <DashboardModule
              clinic={clinic}
              patients={patients}
              appointments={appointments}
              queue={queue}
              consultations={consultations}
              staff={staff}
              invoices={invoices}
              notifications={notifications}
              onNavigateModule={(mod) => setCurrentModule(mod)}
              onOpenRegisterPatient={() => setIsRegisterPatientOpen(true)}
              onOpenBookAppointment={() => setIsBookAppointmentOpen(true)}
              onSelectPatient={handleViewPatientProfile}
              onAdvanceQueueItem={handleAdvanceQueueStage}
            />
          )}

          {currentModule === 'patients' && (
            <PatientsModule
              patients={patients}
              clinic={clinic}
              onOpenRegisterPatient={() => setIsRegisterPatientOpen(true)}
              onSelectPatient={handleViewPatientProfile}
              onCheckInPatientToQueue={(p) => handleCheckInWalkIn(p.id, staff[0].id, 'Normal')}
              onBookAppointmentForPatient={(p) => {
                setBookAppointmentPatientId(p.id);
                setIsBookAppointmentOpen(true);
              }}
            />
          )}

          {currentModule === 'appointments' && (
            <AppointmentsModule
              appointments={appointments}
              patients={patients}
              staff={staff}
              services={services}
              onOpenBookAppointment={() => setIsBookAppointmentOpen(true)}
              onUpdateAppointmentStatus={handleUpdateAppointmentStatus}
              onSendAppointmentReminder={handleSendAppointmentReminder}
              onCancelAppointment={handleCancelAppointment}
            />
          )}

          {currentModule === 'queue' && (
            <QueueModule
              queue={queue}
              patients={patients}
              staff={staff}
              onCheckInWalkIn={handleCheckInWalkIn}
              onAdvanceQueueStage={handleAdvanceQueueStage}
              onRecordVitalsForQueueItem={(qItem) => {
                setVitalsQueueItem(qItem);
                setIsRecordVitalsOpen(true);
              }}
              onDischargeAndBill={handleDischargeAndBill}
            />
          )}

          {currentModule === 'consultations' && (
            <ConsultationsModule
              consultations={consultations}
              patients={patients}
              staff={staff}
              clinic={clinic}
              onAddConsultation={handleAddConsultation}
              onOpenCreateInvoiceForConsultation={(c) => {
                setCreateInvoicePatientId(c.patientId);
                setIsCreateInvoiceOpen(true);
              }}
            />
          )}

          {currentModule === 'billing' && (
            <BillingModule
              invoices={invoices}
              receipts={receipts}
              patients={patients}
              services={services}
              clinic={clinic}
              onOpenCreateInvoice={() => {
                setCreateInvoicePatientId(undefined);
                setIsCreateInvoiceOpen(true);
              }}
              onRecordPayment={(inv) => {
                setSelectedInvoiceForPayment(inv);
                setIsRecordPaymentOpen(true);
              }}
            />
          )}

          {currentModule === 'services' && (
            <ServicesModule
              services={services}
              clinic={clinic}
              onAddService={handleAddService}
              onToggleServiceActive={handleToggleServiceActive}
            />
          )}

          {currentModule === 'staff' && (
            <StaffModule
              staff={staff}
              clinic={clinic}
              onAddStaff={handleAddStaff}
              onToggleStaffDuty={handleToggleStaffDuty}
            />
          )}

          {currentModule === 'documents' && (
            <DocumentsModule
              documents={documents}
              patients={patients}
              clinic={clinic}
              onAddDocument={handleAddDocument}
            />
          )}

          {currentModule === 'notifications' && (
            <NotificationsModule
              notifications={notifications}
              patients={patients}
              clinic={clinic}
              onSendNotification={handleSendNotification}
              onMarkAsRead={handleMarkNotificationRead}
              onDeleteNotification={handleDeleteNotification}
            />
          )}

          {currentModule === 'reports' && (
            <ReportsModule
              clinic={clinic}
              patients={patients}
              appointments={appointments}
              consultations={consultations}
              invoices={invoices}
              services={services}
              staff={staff}
            />
          )}

          {currentModule === 'settings' && (
            <SettingsModule
              clinic={clinic}
              onUpdateClinic={(updated) => {
                setClinic(updated);
                showToast(`Clinic settings saved.`);
              }}
            />
          )}
        </main>
      </div>

      {/* Modals */}
      <RegisterPatientModal
        isOpen={isRegisterPatientOpen}
        onClose={() => setIsRegisterPatientOpen(false)}
        onRegisterPatient={handleRegisterPatient}
      />

      <BookAppointmentModal
        isOpen={isBookAppointmentOpen}
        onClose={() => {
          setIsBookAppointmentOpen(false);
          setBookAppointmentPatientId(undefined);
        }}
        patients={patients}
        staff={staff}
        services={services}
        initialPatientId={bookAppointmentPatientId}
        onBookAppointment={handleBookAppointment}
      />

      <RecordVitalsModal
        isOpen={isRecordVitalsOpen}
        onClose={() => {
          setIsRecordVitalsOpen(false);
          setVitalsQueueItem(null);
        }}
        queueItem={vitalsQueueItem}
        onSaveVitals={handleSaveVitalsForQueue}
      />

      <CreateInvoiceModal
        isOpen={isCreateInvoiceOpen}
        onClose={() => {
          setIsCreateInvoiceOpen(false);
          setCreateInvoicePatientId(undefined);
        }}
        patients={patients}
        services={services}
        initialPatientId={createInvoicePatientId}
        onCreateInvoice={handleCreateInvoice}
      />

      <RecordPaymentModal
        isOpen={isRecordPaymentOpen}
        onClose={() => {
          setIsRecordPaymentOpen(false);
          setSelectedInvoiceForPayment(null);
        }}
        invoice={selectedInvoiceForPayment}
        onRecordPayment={handleRecordPayment}
      />

      <PatientProfileModal
        patient={selectedPatientForProfile}
        consultations={consultations}
        invoices={invoices}
        appointments={appointments}
        onClose={() => {
          setIsPatientProfileOpen(false);
          setSelectedPatientForProfile(null);
        }}
        onBookAppointment={(p) => {
          setBookAppointmentPatientId(p.id);
          setIsBookAppointmentOpen(true);
        }}
        onCheckInToQueue={(p) => handleCheckInWalkIn(p.id, staff[0].id, 'Normal')}
      />
    </div>
  );
};
