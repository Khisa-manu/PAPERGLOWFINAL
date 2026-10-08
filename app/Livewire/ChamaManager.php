<?php

namespace App\Livewire;

use Livewire\Component;

class ChamaManager extends Component
{
    public string $activeTab = 'dashboard';
    public string $search = '';

    // Record Contribution Form State
    public string $selectedMemberId = '1';
    public string $contributionMonth = 'October 2026';
    public float $amountKes = 5000;
    public float $welfareKes = 500;
    public string $paymentMethod = 'mpesa';
    public string $transactionRef = '';
    public string $successMessage = '';

    // In-memory demo dataset representing MariaDB records
    public array $members = [
        [
            'id' => '1',
            'member_number' => 'UB-001',
            'name' => 'Wanjiku Kamau',
            'phone' => '+254 712 345 678',
            'role' => 'Chairperson',
            'status' => 'active',
            'savings_kes' => 280000,
            'welfare_kes' => 14000,
            'loan_balance_kes' => 0,
            'shares' => 28,
        ],
        [
            'id' => '2',
            'member_number' => 'UB-002',
            'name' => 'Brian Ochieng',
            'phone' => '+254 723 456 789',
            'role' => 'Treasurer',
            'status' => 'active',
            'savings_kes' => 310000,
            'welfare_kes' => 14000,
            'loan_balance_kes' => 75000,
            'shares' => 31,
        ],
        [
            'id' => '3',
            'member_number' => 'UB-003',
            'name' => 'Faith Mwangi',
            'phone' => '+254 734 567 890',
            'role' => 'Secretary',
            'status' => 'active',
            'savings_kes' => 245000,
            'welfare_kes' => 14000,
            'loan_balance_kes' => 0,
            'shares' => 24,
        ],
        [
            'id' => '4',
            'member_number' => 'UB-004',
            'name' => 'Kelvin Kiprop',
            'phone' => '+254 745 678 901',
            'role' => 'Member',
            'status' => 'active',
            'savings_kes' => 190000,
            'welfare_kes' => 14000,
            'loan_balance_kes' => 120000,
            'shares' => 19,
        ],
        [
            'id' => '5',
            'member_number' => 'UB-005',
            'name' => 'Amina Hassan',
            'phone' => '+254 756 789 012',
            'role' => 'Member',
            'status' => 'active',
            'savings_kes' => 220000,
            'welfare_kes' => 14000,
            'loan_balance_kes' => 0,
            'shares' => 22,
        ],
    ];

    public array $contributions = [
        [
            'id' => 'c1',
            'member_name' => 'Wanjiku Kamau',
            'member_number' => 'UB-001',
            'month' => 'October 2026',
            'amount_kes' => 5000,
            'welfare_kes' => 500,
            'total_kes' => 5500,
            'date' => '2026-10-04',
            'ref' => 'QHL778129',
            'method' => 'M-Pesa',
            'status' => 'Confirmed',
        ],
        [
            'id' => 'c2',
            'member_name' => 'Brian Ochieng',
            'member_number' => 'UB-002',
            'month' => 'October 2026',
            'amount_kes' => 5000,
            'welfare_kes' => 500,
            'total_kes' => 5500,
            'date' => '2026-10-05',
            'ref' => 'QHL891234',
            'method' => 'M-Pesa',
            'status' => 'Confirmed',
        ],
        [
            'id' => 'c3',
            'member_name' => 'Faith Mwangi',
            'member_number' => 'UB-003',
            'month' => 'October 2026',
            'amount_kes' => 5000,
            'welfare_kes' => 500,
            'total_kes' => 5500,
            'date' => '2026-10-06',
            'ref' => 'QHL942111',
            'method' => 'Bank Transfer',
            'status' => 'Confirmed',
        ],
    ];

    public array $loans = [
        [
            'id' => 'l1',
            'loan_code' => 'LN-2026-004',
            'member_name' => 'Brian Ochieng',
            'type' => 'Business Booster',
            'principal_kes' => 100000,
            'rate' => 10,
            'repayable_kes' => 110000,
            'balance_kes' => 75000,
            'monthly_kes' => 18333,
            'status' => 'Active',
            'disbursed' => '2026-07-15',
        ],
        [
            'id' => 'l2',
            'loan_code' => 'LN-2026-005',
            'member_name' => 'Kelvin Kiprop',
            'type' => 'Development Loan',
            'principal_kes' => 150000,
            'rate' => 10,
            'repayable_kes' => 165000,
            'balance_kes' => 120000,
            'monthly_kes' => 27500,
            'status' => 'Active',
            'disbursed' => '2026-08-01',
        ],
    ];

    public function recordContribution(): void
    {
        $this->validate([
            'amountKes' => 'required|numeric|min:500',
            'welfareKes' => 'required|numeric|min:100',
            'transactionRef' => 'required|string|min:4',
        ]);

        $member = collect($this->members)->firstWhere('id', $this->selectedMemberId);
        $memberName = $member['name'] ?? 'Member';
        $memberNum = $member['member_number'] ?? 'UB-000';

        $newContribution = [
            'id' => 'c'.(count($this->contributions) + 1),
            'member_name' => $memberName,
            'member_number' => $memberNum,
            'month' => $this->contributionMonth,
            'amount_kes' => $this->amountKes,
            'welfare_kes' => $this->welfareKes,
            'total_kes' => $this->amountKes + $this->welfareKes,
            'date' => date('Y-m-d'),
            'ref' => strtoupper($this->transactionRef),
            'method' => strtoupper($this->paymentMethod),
            'status' => 'Confirmed',
        ];

        array_unshift($this->contributions, $newContribution);

        // Update member balance
        foreach ($this->members as &$m) {
            if ($m['id'] === $this->selectedMemberId) {
                $m['savings_kes'] += $this->amountKes;
                $m['welfare_kes'] += $this->welfareKes;
                break;
            }
        }

        $this->successMessage = "KES " . number_format($this->amountKes + $this->welfareKes) . " contribution recorded for {$memberName} (Ref: {$newContribution['ref']})";
        $this->transactionRef = '';
    }

    public function render()
    {
        $filteredMembers = collect($this->members)->filter(function ($m) {
            if (empty($this->search)) return true;
            return str_contains(strtolower($m['name']), strtolower($this->search)) ||
                   str_contains(strtolower($m['member_number']), strtolower($this->search)) ||
                   str_contains(strtolower($m['phone']), strtolower($this->search));
        })->values()->all();

        $totalSavings = collect($this->members)->sum('savings_kes');
        $totalLoansOut = collect($this->members)->sum('loan_balance_kes');
        $totalWelfare = collect($this->members)->sum('welfare_kes');

        return view('livewire.chama-manager', [
            'filteredMembers' => $filteredMembers,
            'totalSavings' => $totalSavings,
            'totalLoansOut' => $totalLoansOut,
            'totalWelfare' => $totalWelfare,
        ]);
    }
}
