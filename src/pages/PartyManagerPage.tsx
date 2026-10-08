import React, { useState, useEffect } from 'react';
import { api } from '../services/api';
import {
  PartyModule,
  PartyMember,
  PartyBranch,
  PartyDepartment,
  PartyEvent,
  PartyTask,
  PartyCommunication,
  PartyDocument,
  PartyFinanceTransaction,
  PartyAuditLog,
  PartyAdminUser,
  PartyOrganizationSettings,
} from '../types/partyManager';
import {
  DEFAULT_PARTY_SETTINGS,
  DEFAULT_PARTY_BRANCHES,
  DEFAULT_PARTY_DEPARTMENTS,
  DEFAULT_PARTY_MEMBERS,
  DEFAULT_PARTY_EVENTS,
  DEFAULT_PARTY_TASKS,
  DEFAULT_PARTY_COMMS,
  DEFAULT_PARTY_DOCS,
  DEFAULT_PARTY_TRANSACTIONS,
  DEFAULT_PARTY_AUDIT_LOGS,
  DEFAULT_PARTY_ADMIN_USERS,
} from '../data/defaultPartyManagerData';

import { PartySidebar } from '../components/partyManager/PartySidebar';
import { PartyHeader } from '../components/partyManager/PartyHeader';
import { PartyDashboardModule } from '../components/partyManager/PartyDashboardModule';
import { PartyOrgModule } from '../components/partyManager/PartyOrgModule';
import { PartyMembersModule } from '../components/partyManager/PartyMembersModule';
import { PartyBranchesModule } from '../components/partyManager/PartyBranchesModule';
import { PartyEventsModule } from '../components/partyManager/PartyEventsModule';
import { PartyTasksModule } from '../components/partyManager/PartyTasksModule';
import { PartyCommsModule } from '../components/partyManager/PartyCommsModule';
import { PartyDocsModule } from '../components/partyManager/PartyDocsModule';
import { PartyFinanceModule } from '../components/partyManager/PartyFinanceModule';
import { PartyReportsModule } from '../components/partyManager/PartyReportsModule';
import { PartyAdminModule } from '../components/partyManager/PartyAdminModule';

interface PartyManagerPageProps {
  onBackToPaperglow: () => void;
}

export const PartyManagerPage: React.FC<PartyManagerPageProps> = ({ onBackToPaperglow }) => {
  const [currentModule, setCurrentModule] = useState<PartyModule>('dashboard');
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [selectedBranchId, setSelectedBranchId] = useState<string>('all');
  const [searchQuery, setSearchQuery] = useState('');

  // Toast alert
  const [toastMessage, setToastMessage] = useState<string | null>(null);

  const showToast = (msg: string) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(null), 3500);
  };

  // State initialized with MariaDB backend data
  const [settings, setSettings] = useState<PartyOrganizationSettings>(DEFAULT_PARTY_SETTINGS);
  const [branches, setBranches] = useState<PartyBranch[]>([]);
  const [departments] = useState<PartyDepartment[]>(DEFAULT_PARTY_DEPARTMENTS);
  const [members, setMembers] = useState<PartyMember[]>([]);
  const [events, setEvents] = useState<PartyEvent[]>([]);
  const [tasks, setTasks] = useState<PartyTask[]>(DEFAULT_PARTY_TASKS);
  const [communications, setCommunications] = useState<PartyCommunication[]>([]);
  const [documents, setDocuments] = useState<PartyDocument[]>(DEFAULT_PARTY_DOCS);
  const [transactions, setTransactions] = useState<PartyFinanceTransaction[]>([]);
  const [auditLogs, setAuditLogs] = useState<PartyAuditLog[]>(DEFAULT_PARTY_AUDIT_LOGS);
  const [adminUsers, setAdminUsers] = useState<PartyAdminUser[]>(DEFAULT_PARTY_ADMIN_USERS);

  // Cloud Synchronization State
  const [isCloudSyncing, setIsCloudSyncing] = useState<boolean>(false);
  const [isCloudOnline, setIsCloudOnline] = useState<boolean>(true);

  const fetchCloudPartyData = async () => {
    setIsCloudSyncing(true);
    try {
      const [memRes, brRes, evRes, finRes] = await Promise.allSettled([
        api.party.getMembers(),
        api.party.getBranches(),
        api.party.getEvents(),
        api.party.getFinance(),
      ]);

      if (memRes.status === 'fulfilled' && memRes.value?.data && memRes.value.data.length > 0) {
        const cloudMembers: PartyMember[] = memRes.value.data.map((m: any) => ({
          id: String(m.id || m.uuid),
          membershipNumber: m.member_number || `PGM-${m.id}`,
          fullName: m.full_name || '',
          idNumber: m.id_number || '',
          email: m.email || '',
          phone: m.phone || '',
          gender: 'other' as any,
          county: m.county || 'Nairobi',
          constituency: m.constituency || 'Starehe',
          ward: m.ward || 'Central',
          branchId: String(m.branch_id || 'br-1'),
          status: (m.status || 'active') as any,
          tier: 'regular' as any,
          joinDate: m.joined_date || new Date().toISOString().split('T')[0],
          expiryDate: '2026-12-31',
          duesStatus: (m.dues_status || 'paid') as any,
          outstandingDues: m.dues_status === 'overdue' ? 1200 : 0,
        }));
        setMembers(cloudMembers);
      }

      if (brRes.status === 'fulfilled' && brRes.value?.data && brRes.value.data.length > 0) {
        const cloudBranches: PartyBranch[] = brRes.value.data.map((b: any) => ({
          id: String(b.id || b.uuid),
          code: b.code || `BR-${b.id}`,
          name: b.name || '',
          region: b.constituency || 'Nairobi Region',
          county: b.county || 'Nairobi',
          officeAddress: `${b.name} Secretariat Office`,
          coordinatorName: b.leadership || 'County Coordinator',
          coordinatorPhone: '+254712000000',
          coordinatorEmail: 'coordinator@paperglow.co.ke',
          memberCount: Number(b.member_count || 0),
          status: (b.status || 'active') as any,
          establishedDate: '2024-01-15',
          budgetAllocation: 500000,
          spentBudget: 120000,
        }));
        setBranches(cloudBranches);
      }

      if (evRes.status === 'fulfilled' && evRes.value?.data && evRes.value.data.length > 0) {
        const cloudEvents: PartyEvent[] = evRes.value.data.map((e: any) => ({
          id: String(e.id || e.uuid),
          title: e.title || '',
          eventType: (e.type || 'county_delegate') as any,
          date: e.date || new Date().toISOString().split('T')[0],
          time: '09:00 AM',
          venue: e.venue || 'County Hall',
          attendeesExpected: Number(e.attendees_count || 50),
          attendeesRecorded: Number(e.attendees_count || 50),
          status: (e.status || 'upcoming') as any,
          agendaItems: ['Opening remarks', 'Statutory report', 'Resolutions'],
          actionItems: [],
        }));
        setEvents(cloudEvents);
      }

      if (finRes.status === 'fulfilled' && finRes.value?.data && finRes.value.data.length > 0) {
        const cloudTxns: PartyFinanceTransaction[] = finRes.value.data.map((f: any) => ({
          id: String(f.id || f.uuid),
          referenceNo: f.reference || `TXN-${f.id}`,
          type: (f.category || 'membership_dues') as any,
          direction: (f.type || 'income') as any,
          amount: Number(f.amount || 0),
          date: f.date || new Date().toISOString().split('T')[0],
          partyOrMemberName: f.source || 'Party Secretariat',
          paymentChannel: (f.payment_method || 'mpesa_paybill') as any,
          status: 'verified' as any,
          description: f.description || 'MariaDB Ledger Entry',
        }));
        setTransactions(cloudTxns);
      }

      setIsCloudOnline(true);
    } catch (err) {
      console.warn('[Party Cloud] Offline cache fallback:', err);
      setIsCloudOnline(false);
    } finally {
      setIsCloudSyncing(false);
    }
  };

  useEffect(() => {
    fetchCloudPartyData();
  }, []);

  // Handler: Add Member with MariaDB persistence
  const handleAddMember = (newMember: PartyMember) => {
    setMembers((prev) => [newMember, ...prev]);

    api.party.createMember({
      member_number: newMember.membershipNumber,
      full_name: newMember.fullName,
      id_number: newMember.idNumber,
      phone: newMember.phone,
      email: newMember.email,
      county: newMember.county,
      constituency: newMember.constituency,
      ward: newMember.ward,
      branch_id: newMember.branchId,
      role: 'Member',
      status: newMember.status,
      dues_status: newMember.duesStatus,
      joined_date: newMember.joinDate,
    }).catch((err) => console.warn('Could not persist member to backend:', err));

    // Update branch count
    setBranches((prev) =>
      prev.map((b) => (b.id === newMember.branchId ? { ...b, memberCount: b.memberCount + 1 } : b))
    );

    // Audit log
    const log: PartyAuditLog = {
      id: `aud-${Date.now()}`,
      timestamp: new Date().toISOString().replace('T', ' ').substring(0, 19),
      actorName: 'Adv. Kenneth Omondi Otieno',
      actorRole: 'Secretary General',
      action: 'REGISTER_MEMBER',
      module: 'members',
      details: `Enrolled ${newMember.fullName} (Ref: ${newMember.membershipNumber}) under ${newMember.county} County.`,
      ipAddress: '197.232.88.14',
    };
    setAuditLogs((prev) => [log, ...prev]);
    showToast(`Member ${newMember.fullName} (${newMember.membershipNumber}) registered.`);
  };

  // Handler: Update Member
  const handleUpdateMember = (updated: PartyMember) => {
    setMembers((prev) => prev.map((m) => (m.id === updated.id ? updated : m)));
    api.party.updateMember(updated.id, {
      full_name: updated.fullName,
      phone: updated.phone,
      email: updated.email,
      county: updated.county,
      status: updated.status,
      dues_status: updated.duesStatus,
    }).catch(() => {});
    showToast(`Updated dossier for ${updated.fullName}.`);
  };

  // Handler: Record Member Dues Payment
  const handleRecordDuesPayment = (memberId: string, amount: number, channel: string) => {
    const member = members.find((m) => m.id === memberId);
    if (!member) return;

    const today = new Date().toISOString().split('T')[0];
    const updatedMember: PartyMember = {
      ...member,
      duesStatus: 'paid',
      outstandingDues: 0,
      lastDuesPaymentDate: today,
    };
    setMembers((prev) => prev.map((m) => (m.id === memberId ? updatedMember : m)));

    // Add financial transaction
    const newTxn: PartyFinanceTransaction = {
      id: `fin-${Date.now()}`,
      referenceNo: `TXN-2025-${Math.floor(100 + Math.random() * 900)}`,
      type: 'membership_dues',
      direction: 'income',
      amount,
      date: today,
      partyOrMemberName: `${member.fullName} (${member.membershipNumber})`,
      branchId: member.branchId,
      paymentChannel: channel as any,
      status: 'verified',
      description: `Annual subscription renewal payment via ${channel.replace('_', ' ')}`,
    };
    setTransactions((prev) => [newTxn, ...prev]);

    api.party.createFinance({
      reference: newTxn.referenceNo,
      type: 'income',
      category: 'membership_dues',
      amount,
      date: today,
      source: member.fullName,
      payment_method: channel,
      status: 'completed',
      description: newTxn.description,
    }).catch(() => {});

    showToast(`Dues of KES ${amount.toLocaleString()} recorded for ${member.fullName}.`);
  };

  // Handler: Add Branch
  const handleAddBranch = (branch: PartyBranch) => {
    setBranches((prev) => [...prev, branch]);
    api.party.createBranch({
      name: branch.name,
      code: branch.code,
      county: branch.county,
      constituency: branch.region,
      leadership: branch.coordinatorName,
      member_count: branch.memberCount,
      status: 'active',
    }).catch(() => {});
    showToast(`Regional chapter "${branch.name}" established.`);
  };

  // Handler: Update Branch
  const handleUpdateBranch = (branch: PartyBranch) => {
    setBranches((prev) => prev.map((b) => (b.id === branch.id ? branch : b)));
    showToast(`Branch "${branch.name}" configuration saved.`);
  };

  // Handler: Add Event
  const handleAddEvent = (event: PartyEvent) => {
    setEvents((prev) => [event, ...prev]);
    api.party.createEvent({
      title: event.title,
      type: event.eventType,
      date: event.date,
      venue: event.venue,
      county: 'Nairobi',
      status: event.status,
      attendees_count: event.attendeesExpected,
      budget: 150000,
    }).catch(() => {});
    showToast(`Assembly "${event.title}" scheduled.`);
  };

  // Handler: Update Event
  const handleUpdateEvent = (event: PartyEvent) => {
    setEvents((prev) => prev.map((e) => (e.id === event.id ? event : e)));
    showToast(`Meeting session "${event.title}" updated.`);
  };

  // Handler: Add Task
  const handleAddTask = (task: PartyTask) => {
    setTasks((prev) => [task, ...prev]);
    showToast(`Task assigned to ${task.assignedTo}.`);
  };

  // Handler: Update Task
  const handleUpdateTask = (task: PartyTask) => {
    setTasks((prev) => prev.map((t) => (t.id === task.id ? task : t)));
    showToast(`Task status updated to ${task.status.replace('_', ' ')}.`);
  };

  // Handler: Add Communication
  const handleAddCommunication = (comm: PartyCommunication) => {
    setCommunications((prev) => [comm, ...prev]);
    showToast(`Communiqué "${comm.title}" dispatched.`);
  };

  // Handler: Add Document
  const handleAddDocument = (doc: PartyDocument) => {
    setDocuments((prev) => [doc, ...prev]);
    showToast(`Document "${doc.title}" archived in legal vault.`);
  };

  // Handler: Add Transaction
  const handleAddTransaction = (txn: PartyFinanceTransaction) => {
    setTransactions((prev) => [txn, ...prev]);
    api.party.createFinance({
      reference: txn.referenceNo,
      type: txn.direction,
      category: txn.type,
      amount: txn.amount,
      date: txn.date,
      source: txn.partyOrMemberName,
      payment_method: txn.paymentChannel,
      status: 'completed',
      description: txn.description,
    }).catch(() => {});
    showToast(`Ledger entry ${txn.referenceNo} (KES ${txn.amount.toLocaleString()}) committed.`);
  };

  // Handler: Add Admin User
  const handleAddUser = (user: PartyAdminUser) => {
    setAdminUsers((prev) => [...prev, user]);
    showToast(`Officer account created for ${user.name}.`);
  };

  // Handler: Reset Demo Data
  const handleResetData = () => {
    if (confirm('Reset all Paperglow Political Party Manager demo state to default Kenyan party records?')) {
      localStorage.removeItem('paperglow_party_settings');
      localStorage.removeItem('paperglow_party_branches');
      localStorage.removeItem('paperglow_party_members');
      localStorage.removeItem('paperglow_party_events');
      localStorage.removeItem('paperglow_party_tasks');
      localStorage.removeItem('paperglow_party_comms');
      localStorage.removeItem('paperglow_party_docs');
      localStorage.removeItem('paperglow_party_txns');
      localStorage.removeItem('paperglow_party_audit');
      localStorage.removeItem('paperglow_party_users');

      setSettings(DEFAULT_PARTY_SETTINGS);
      setBranches(DEFAULT_PARTY_BRANCHES);
      setMembers(DEFAULT_PARTY_MEMBERS);
      setEvents(DEFAULT_PARTY_EVENTS);
      setTasks(DEFAULT_PARTY_TASKS);
      setCommunications(DEFAULT_PARTY_COMMS);
      setDocuments(DEFAULT_PARTY_DOCS);
      setTransactions(DEFAULT_PARTY_TRANSACTIONS);
      setAuditLogs(DEFAULT_PARTY_AUDIT_LOGS);
      setAdminUsers(DEFAULT_PARTY_ADMIN_USERS);

      showToast('Party registry state reset to default demo dataset.');
    }
  };

  // Quick Action Modals State
  const [quickAddMemberOpen, setQuickAddMemberOpen] = useState(false);
  const [quickScheduleEventOpen, setQuickScheduleEventOpen] = useState(false);
  const [quickFinanceOpen, setQuickFinanceOpen] = useState(false);

  return (
    <div className="min-h-screen bg-slate-100 flex">
      {/* Toast Alert */}
      {toastMessage && (
        <div className="fixed bottom-5 right-5 z-50 bg-slate-900 text-white px-4 py-3 rounded-xl shadow-2xl border border-slate-700 text-xs flex items-center gap-2 animate-in slide-in-from-bottom duration-200">
          <div className="w-2 h-2 rounded-full bg-red-500 animate-ping" />
          <span>{toastMessage}</span>
        </div>
      )}

      {/* Sidebar */}
      <PartySidebar
        currentModule={currentModule}
        onSelectModule={setCurrentModule}
        onBackToPaperglow={onBackToPaperglow}
        memberCount={members.length}
        openTasksCount={tasks.filter((t) => t.status !== 'completed').length}
        upcomingEventsCount={events.filter((e) => e.status === 'upcoming').length}
        isMobileOpen={isMobileMenuOpen}
        onCloseMobile={() => setIsMobileMenuOpen(false)}
      />

      {/* Main Content Area */}
      <div className="flex-1 lg:pl-64 flex flex-col min-w-0">
        <PartyHeader
          currentModule={currentModule}
          onOpenMobileMenu={() => setIsMobileMenuOpen(true)}
          branches={branches}
          selectedBranchId={selectedBranchId}
          onSelectBranchId={setSelectedBranchId}
          searchQuery={searchQuery}
          onSearchChange={setSearchQuery}
          onQuickAddMember={() => setCurrentModule('members')}
          onQuickScheduleEvent={() => setCurrentModule('events')}
          onQuickRecordFinance={() => setCurrentModule('finance')}
          isOnline={isCloudOnline}
          isSyncing={isCloudSyncing}
          onManualSync={fetchCloudPartyData}
        />

        <main className="flex-1 p-4 sm:p-6 max-w-7xl w-full mx-auto pb-16">
          {currentModule === 'dashboard' && (
            <PartyDashboardModule
              members={members}
              branches={branches}
              events={events}
              tasks={tasks}
              transactions={transactions}
              communications={communications}
              onNavigate={(mod) => setCurrentModule(mod)}
              onQuickAddMember={() => setCurrentModule('members')}
              onQuickScheduleEvent={() => setCurrentModule('events')}
              onQuickRecordFinance={() => setCurrentModule('finance')}
            />
          )}

          {currentModule === 'organization' && (
            <PartyOrgModule
              settings={settings}
              departments={departments}
              branches={branches}
              onUpdateSettings={setSettings}
              onNavigateToBranches={() => setCurrentModule('branches')}
              onNavigateToDocuments={() => setCurrentModule('documents')}
            />
          )}

          {currentModule === 'members' && (
            <PartyMembersModule
              members={members}
              branches={branches}
              onAddMember={handleAddMember}
              onUpdateMember={handleUpdateMember}
              onRecordDuesPayment={handleRecordDuesPayment}
            />
          )}

          {currentModule === 'branches' && (
            <PartyBranchesModule
              branches={branches}
              members={members}
              onAddBranch={handleAddBranch}
              onUpdateBranch={handleUpdateBranch}
            />
          )}

          {currentModule === 'events' && (
            <PartyEventsModule
              events={events}
              branches={branches}
              onAddEvent={handleAddEvent}
              onUpdateEvent={handleUpdateEvent}
            />
          )}

          {currentModule === 'tasks' && (
            <PartyTasksModule
              tasks={tasks}
              departments={departments}
              branches={branches}
              onAddTask={handleAddTask}
              onUpdateTask={handleUpdateTask}
            />
          )}

          {currentModule === 'communications' && (
            <PartyCommsModule
              communications={communications}
              onAddCommunication={handleAddCommunication}
            />
          )}

          {currentModule === 'documents' && (
            <PartyDocsModule
              documents={documents}
              onAddDocument={handleAddDocument}
            />
          )}

          {currentModule === 'finance' && (
            <PartyFinanceModule
              transactions={transactions}
              branches={branches}
              onAddTransaction={handleAddTransaction}
            />
          )}

          {currentModule === 'reports' && (
            <PartyReportsModule
              members={members}
              branches={branches}
              events={events}
              transactions={transactions}
              auditLogs={auditLogs}
            />
          )}

          {currentModule === 'admin' && (
            <PartyAdminModule
              adminUsers={adminUsers}
              auditLogs={auditLogs}
              settings={settings}
              branches={branches}
              onAddUser={handleAddUser}
              onUpdateUser={(updated) =>
                setAdminUsers((prev) => prev.map((u) => (u.id === updated.id ? updated : u)))
              }
              onUpdateSettings={setSettings}
            />
          )}

          {/* Reset Demo Data & Info Footer */}
          <div className="mt-12 pt-6 border-t border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <div>
              <strong>Paperglow Political Party Manager</strong> • Registered Under Political Parties Act 2011 (Cap 7D).
            </div>
            <button
              onClick={handleResetData}
              className="text-slate-400 hover:text-red-600 underline font-medium transition-colors"
            >
              Reset Demo Records to Factory Defaults
            </button>
          </div>
        </main>
      </div>
    </div>
  );
};
