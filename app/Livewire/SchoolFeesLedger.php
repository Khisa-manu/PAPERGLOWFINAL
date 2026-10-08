<?php

namespace App\Livewire;

use Livewire\Component;

class SchoolFeesLedger extends Component
{
    public string $selectedClass = 'Grade 7';
    public string $search = '';

    // Record Fee Payment Form
    public string $studentId = '1';
    public float $amountKes = 20000;
    public string $paymentMethod = 'mpesa_paybill';
    public string $transactionRef = '';
    public string $term = 'Term 1';
    public string $successMessage = '';

    public array $students = [
        [
            'id' => '1',
            'admission_no' => 'PA-2026-104',
            'name' => 'Emmanuel Kiprotich',
            'class' => 'Grade 7',
            'parent_name' => 'John Kiprotich',
            'parent_phone' => '+254 712 998 877',
            'fee_billed_kes' => 45000,
            'fee_paid_kes' => 45000,
            'balance_kes' => 0,
            'status' => 'Cleared',
        ],
        [
            'id' => '2',
            'admission_no' => 'PA-2026-105',
            'name' => 'Stacy Muthoni',
            'class' => 'Grade 7',
            'parent_name' => 'Grace Muthoni',
            'parent_phone' => '+254 723 887 766',
            'fee_billed_kes' => 45000,
            'fee_paid_kes' => 25000,
            'balance_kes' => 20000,
            'status' => 'Partial',
        ],
        [
            'id' => '3',
            'admission_no' => 'PA-2026-106',
            'name' => 'Trevor Otieno',
            'class' => 'Grade 7',
            'parent_name' => 'Silas Otieno',
            'parent_phone' => '+254 734 776 655',
            'fee_billed_kes' => 45000,
            'fee_paid_kes' => 15000,
            'balance_kes' => 30000,
            'status' => 'Arrears',
        ],
    ];

    public function recordPayment(): void
    {
        $this->validate([
            'amountKes' => 'required|numeric|min:500',
            'transactionRef' => 'required|string|min:4',
        ]);

        $studentName = '';
        foreach ($this->students as &$s) {
            if ($s['id'] === $this->studentId) {
                $studentName = $s['name'];
                $s['fee_paid_kes'] += $this->amountKes;
                $s['balance_kes'] = max(0, $s['fee_billed_kes'] - $s['fee_paid_kes']);
                $s['status'] = ($s['balance_kes'] == 0) ? 'Cleared' : 'Partial';
                break;
            }
        }

        $receiptNo = 'REC-2026-' . rand(1000, 9999);
        $this->successMessage = "Payment of KES " . number_format($this->amountKes) . " recorded for {$studentName}. Receipt #{$receiptNo} generated.";
        $this->transactionRef = '';
    }

    public function render()
    {
        $filtered = collect($this->students)->filter(function ($s) {
            if (!empty($this->search)) {
                return str_contains(strtolower($s['name']), strtolower($this->search)) ||
                       str_contains(strtolower($s['admission_no']), strtolower($this->search));
            }
            return true;
        })->values()->all();

        $totalBilled = collect($this->students)->sum('fee_billed_kes');
        $totalPaid = collect($this->students)->sum('fee_paid_kes');
        $totalOutstanding = collect($this->students)->sum('balance_kes');

        return view('livewire.school-fees-ledger', [
            'studentsList' => $filtered,
            'totalBilled' => $totalBilled,
            'totalPaid' => $totalPaid,
            'totalOutstanding' => $totalOutstanding,
        ]);
    }
}
