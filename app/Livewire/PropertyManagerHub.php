<?php

namespace App\Livewire;

use Livewire\Component;

class PropertyManagerHub extends Component
{
    public string $activeFilter = 'all'; // all, occupied, vacant, arrears
    public string $search = '';

    public array $units = [
        [
            'id' => 'u1',
            'unit_no' => 'A101',
            'property' => 'Riverside Heights',
            'tenant' => 'David Kimani',
            'phone' => '+254 711 234 567',
            'rent_kes' => 45000,
            'deposit_kes' => 45000,
            'status' => 'paid', // paid, arrears, vacant
            'balance_kes' => 0,
            'due_date' => '5th of each month',
        ],
        [
            'id' => 'u2',
            'unit_no' => 'A102',
            'property' => 'Riverside Heights',
            'tenant' => 'Sarah Wambui',
            'phone' => '+254 722 345 678',
            'rent_kes' => 45000,
            'deposit_kes' => 45000,
            'status' => 'arrears',
            'balance_kes' => 22500,
            'due_date' => '5th of each month',
        ],
        [
            'id' => 'u3',
            'unit_no' => 'B201',
            'property' => 'Riverside Heights',
            'tenant' => 'Unoccupied (Vacant)',
            'phone' => '--',
            'rent_kes' => 52000,
            'deposit_kes' => 52000,
            'status' => 'vacant',
            'balance_kes' => 0,
            'due_date' => '--',
        ],
        [
            'id' => 'u4',
            'unit_no' => 'B202',
            'property' => 'Riverside Heights',
            'tenant' => 'Mercy Chebet',
            'phone' => '+254 733 456 789',
            'rent_kes' => 52000,
            'deposit_kes' => 52000,
            'status' => 'paid',
            'balance_kes' => 0,
            'due_date' => '5th of each month',
        ],
    ];

    public function markAsPaid(string $unitId): void
    {
        foreach ($this->units as &$unit) {
            if ($unit['id'] === $unitId) {
                $unit['status'] = 'paid';
                $unit['balance_kes'] = 0;
                break;
            }
        }
    }

    public function render()
    {
        $filtered = collect($this->units)->filter(function ($u) {
            if ($this->activeFilter !== 'all' && $u['status'] !== $this->activeFilter) {
                return false;
            }
            if (!empty($this->search)) {
                return str_contains(strtolower($u['unit_no']), strtolower($this->search)) ||
                       str_contains(strtolower($u['tenant']), strtolower($this->search));
            }
            return true;
        })->values()->all();

        $totalRentExpected = collect($this->units)->where('status', '!=', 'vacant')->sum('rent_kes');
        $totalCollected = collect($this->units)->where('status', 'paid')->sum('rent_kes');
        $totalArrears = collect($this->units)->sum('balance_kes');

        return view('livewire.property-manager-hub', [
            'filteredUnits' => $filtered,
            'totalRentExpected' => $totalRentExpected,
            'totalCollected' => $totalCollected,
            'totalArrears' => $totalArrears,
            'occupancyRate' => round((count(array_filter($this->units, fn($u) => $u['status'] !== 'vacant')) / count($this->units)) * 100),
        ]);
    }
}
