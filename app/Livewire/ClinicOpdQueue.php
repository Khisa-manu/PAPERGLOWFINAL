<?php

namespace App\Livewire;

use Livewire\Component;

class ClinicOpdQueue extends Component
{
    public string $activeTab = 'queue';
    public string $search = '';

    // Register Patient Form
    public string $patientName = '';
    public string $patientPhone = '';
    public int $patientAge = 28;
    public string $patientGender = 'Female';
    public string $complaint = '';
    public string $successMessage = '';

    // Triage / Vitals Entry Form
    public string $selectedQueueId = '';
    public int $bpSystolic = 120;
    public int $bpDiastolic = 80;
    public int $pulse = 74;
    public float $temp = 36.6;
    public float $weight = 65.0;

    public array $queue = [
        [
            'id' => 'q1',
            'queue_no' => 101,
            'name' => 'Wanjiku Mwangi',
            'opd_no' => 'OPD-2026-089',
            'age' => 34,
            'gender' => 'Female',
            'arrival_time' => '08:45 AM',
            'priority' => 'Normal',
            'stage' => 'in_consultation', // triage, waiting, in_consultation, ready_for_billing, completed
            'doctor' => 'Dr. Brenda Muthoni',
            'vitals_taken' => true,
            'bp' => '118/76',
            'temp' => 36.8,
            'complaint' => 'Persistent dry cough and mild fever',
        ],
        [
            'id' => 'q2',
            'queue_no' => 102,
            'name' => 'Kipchumba Bett',
            'opd_no' => 'OPD-2026-090',
            'age' => 45,
            'gender' => 'Male',
            'arrival_time' => '09:10 AM',
            'priority' => 'Urgent',
            'stage' => 'waiting',
            'doctor' => 'Dr. Brenda Muthoni',
            'vitals_taken' => true,
            'bp' => '142/92',
            'temp' => 37.1,
            'complaint' => 'Acute lower back pain after manual lifting',
        ],
        [
            'id' => 'q3',
            'queue_no' => 103,
            'name' => 'Fatuma Noor',
            'opd_no' => 'OPD-2026-091',
            'age' => 26,
            'gender' => 'Female',
            'arrival_time' => '09:30 AM',
            'priority' => 'Normal',
            'stage' => 'triage',
            'doctor' => 'Unassigned',
            'vitals_taken' => false,
            'bp' => '--/--',
            'temp' => 0.0,
            'complaint' => 'Routine prenatal review',
        ],
    ];

    public function addPatientToQueue(): void
    {
        $this->validate([
            'patientName' => 'required|string|min:3',
            'patientPhone' => 'required|string|min:9',
            'complaint' => 'required|string|min:3',
        ]);

        $nextQueueNo = count($this->queue) + 101;
        $opdNo = 'OPD-2026-0' . (92 + count($this->queue));

        $newEntry = [
            'id' => 'q' . (count($this->queue) + 1),
            'queue_no' => $nextQueueNo,
            'name' => $this->patientName,
            'opd_no' => $opdNo,
            'age' => $this->patientAge,
            'gender' => $this->patientGender,
            'arrival_time' => date('h:i A'),
            'priority' => 'Normal',
            'stage' => 'triage',
            'doctor' => 'Dr. Brenda Muthoni',
            'vitals_taken' => false,
            'bp' => '--/--',
            'temp' => 0.0,
            'complaint' => $this->complaint,
        ];

        $this->queue[] = $newEntry;
        $this->successMessage = "Patient {$this->patientName} registered to Queue #{$nextQueueNo} ({$opdNo})";
        
        $this->patientName = '';
        $this->patientPhone = '';
        $this->complaint = '';
    }

    public function recordVitals(string $queueId): void
    {
        foreach ($this->queue as &$item) {
            if ($item['id'] === $queueId) {
                $item['vitals_taken'] = true;
                $item['bp'] = "{$this->bpSystolic}/{$this->bpDiastolic}";
                $item['temp'] = $this->temp;
                $item['stage'] = 'waiting';
                break;
            }
        }
        $this->successMessage = "Vitals recorded successfully.";
    }

    public function advanceStage(string $queueId, string $nextStage): void
    {
        foreach ($this->queue as &$item) {
            if ($item['id'] === $queueId) {
                $item['stage'] = $nextStage;
                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.clinic-opd-queue', [
            'queueList' => $this->queue,
            'inConsultationCount' => collect($this->queue)->where('stage', 'in_consultation')->count(),
            'waitingCount' => collect($this->queue)->where('stage', 'waiting')->count(),
            'triageCount' => collect($this->queue)->where('stage', 'triage')->count(),
        ]);
    }
}
