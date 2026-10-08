<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-400">Property & Rent Roll</span>
                <span class="text-xs text-slate-500">Livewire 3 + MariaDB</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white">Riverside Heights Management</h1>
            <p class="text-xs sm:text-sm text-slate-500">Occupancy: <strong>{{ $occupancyRate }}%</strong> • Monthly Rent Roll • Automated Arrears Alerts</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">
                DirectAdmin DB: Reconciled
            </span>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Expected Monthly Rent</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                KES {{ number_format($totalRentExpected) }}
            </div>
            <span class="text-xs text-slate-500">Active Tenant Leases</span>
        </div>

        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Collected This Month</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-emerald-600">
                KES {{ number_format($totalCollected) }}
            </div>
            <span class="text-xs text-emerald-600 font-medium">Reconciled via M-Pesa</span>
        </div>

        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Outstanding Rent Arrears</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-red-600">
                KES {{ number_format($totalArrears) }}
            </div>
            <span class="text-xs text-red-500">Automated SMS Reminders Sent</span>
        </div>
    </div>

    <!-- Unit Grid & Filters -->
    <div class="paperglow-panel overflow-hidden">
        <div class="bg-slate-50/50 dark:bg-slate-900/50 px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-3 text-xs font-semibold">
                <button wire:click="$set('activeFilter', 'all')" class="px-2.5 py-1 rounded {{ $activeFilter === 'all' ? 'bg-red-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600' }}">All Units</button>
                <button wire:click="$set('activeFilter', 'paid')" class="px-2.5 py-1 rounded {{ $activeFilter === 'paid' ? 'bg-emerald-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600' }}">Paid</button>
                <button wire:click="$set('activeFilter', 'arrears')" class="px-2.5 py-1 rounded {{ $activeFilter === 'arrears' ? 'bg-red-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600' }}">Arrears</button>
                <button wire:click="$set('activeFilter', 'vacant')" class="px-2.5 py-1 rounded {{ $activeFilter === 'vacant' ? 'bg-slate-600 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600' }}">Vacant</button>
            </div>

            <div class="w-full sm:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search unit number or tenant..." class="w-full px-3 py-1.5 text-xs rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-[11px] tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Unit</th>
                        <th class="px-6 py-3">Tenant Name</th>
                        <th class="px-6 py-3">Contact</th>
                        <th class="px-6 py-3 text-right">Monthly Rent</th>
                        <th class="px-6 py-3 text-right">Balance Due</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach($filteredUnits as $u)
                        <tr>
                            <td class="px-6 py-4 font-mono font-bold">{{ $u['unit_no'] }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $u['tenant'] }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $u['phone'] }}</td>
                            <td class="px-6 py-4 text-right">KES {{ number_format($u['rent_kes']) }}</td>
                            <td class="px-6 py-4 text-right font-bold {{ $u['balance_kes'] > 0 ? 'text-red-600' : 'text-slate-400' }}">
                                {{ $u['balance_kes'] > 0 ? 'KES '.number_format($u['balance_kes']) : 'Nil' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($u['status'] === 'paid')
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700">Rent Paid</span>
                                @elseif($u['status'] === 'arrears')
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-red-50 text-red-700">In Arrears</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 text-slate-600">Vacant</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($u['status'] === 'arrears')
                                    <button wire:click="markAsPaid('{{ $u['id'] }}')" class="px-2.5 py-1 text-xs font-semibold bg-emerald-600 text-white rounded hover:bg-emerald-700">
                                        Mark Paid
                                    </button>
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
