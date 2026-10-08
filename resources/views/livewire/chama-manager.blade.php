<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-red-100 text-red-700 dark:bg-red-950/60 dark:text-red-400">Livewire 3 Monolith</span>
                <span class="text-xs text-slate-500">MariaDB Connected</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white">Ushirika Bora Chama Manager</h1>
            <p class="text-xs sm:text-sm text-slate-500">Reg: REG/KOP/2018/0942 • Monthly Contribution: KES 5,000 • Welfare: KES 500</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400 font-semibold border border-emerald-200 dark:border-emerald-800">
                DirectAdmin DB: Active
            </span>
        </div>
    </div>

    <!-- Alert / Success Notification -->
    @if($successMessage)
        <div class="p-4 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold">✓</span>
                <span>{{ $successMessage }}</span>
            </div>
            <button wire:click="$set('successMessage', '')" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Total Group Savings</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                KES {{ number_format($totalSavings) }}
            </div>
            <span class="text-xs text-emerald-600 font-medium">Reconciled in MariaDB</span>
        </div>

        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Active Loan Book</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-red-600">
                KES {{ number_format($totalLoansOut) }}
            </div>
            <span class="text-xs text-slate-500">Interest rate: 10% per annum</span>
        </div>

        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Welfare & Benevolent Fund</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                KES {{ number_format($totalWelfare) }}
            </div>
            <span class="text-xs text-slate-500">Hospital & Bereavement Cover</span>
        </div>
    </div>

    <!-- Main Workspace Tabs -->
    <div class="paperglow-panel overflow-hidden">
        <div class="border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 px-6 py-3 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4 text-xs sm:text-sm font-semibold">
                <button wire:click="$set('activeTab', 'dashboard')" class="pb-1 {{ $activeTab === 'dashboard' ? 'text-red-600 border-b-2 border-red-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                    Members Ledger ({{ count($members) }})
                </button>
                <button wire:click="$set('activeTab', 'contributions')" class="pb-1 {{ $activeTab === 'contributions' ? 'text-red-600 border-b-2 border-red-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                    Record Contribution
                </button>
                <button wire:click="$set('activeTab', 'loans')" class="pb-1 {{ $activeTab === 'loans' ? 'text-red-600 border-b-2 border-red-600' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                    Active Loans ({{ count($loans) }})
                </button>
            </div>

            <div class="w-full sm:w-64">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search members by name or ID..." class="w-full px-3 py-1.5 text-xs rounded-md border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-red-600">
            </div>
        </div>

        <!-- Tab 1: Members Table -->
        @if($activeTab === 'dashboard')
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-[11px] font-semibold tracking-wider">
                        <tr>
                            <th class="px-6 py-3">Member ID</th>
                            <th class="px-6 py-3">Full Name</th>
                            <th class="px-6 py-3">Phone</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3 text-right">Savings (KES)</th>
                            <th class="px-6 py-3 text-right">Loan Balance</th>
                            <th class="px-6 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($filteredMembers as $m)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-medium text-slate-600 dark:text-slate-400">{{ $m['member_number'] }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $m['name'] }}</td>
                                <td class="px-6 py-4 text-slate-600 dark:text-slate-400">{{ $m['phone'] }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">{{ $m['role'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-right font-bold text-slate-900 dark:text-white">{{ number_format($m['savings_kes']) }}</td>
                                <td class="px-6 py-4 text-right font-medium {{ $m['loan_balance_kes'] > 0 ? 'text-red-600' : 'text-slate-400' }}">
                                    {{ $m['loan_balance_kes'] > 0 ? number_format($m['loan_balance_kes']) : 'Nil' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400">Active</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Tab 2: Record Contribution Form (Interactive Livewire) -->
        @if($activeTab === 'contributions')
            <div class="p-6 sm:p-8 max-w-2xl mx-auto space-y-6">
                <div>
                    <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white">Record Monthly Contribution</h3>
                    <p class="text-xs text-slate-500">Livewire will post this directly to MariaDB on your DirectAdmin server.</p>
                </div>

                <form wire:submit.prevent="recordContribution" class="space-y-4 text-xs sm:text-sm">
                    <div>
                        <label class="block font-medium text-slate-700 dark:text-slate-300 mb-1">Select Member</label>
                        <select wire:model="selectedMemberId" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                            @foreach($members as $m)
                                <option value="{{ $m['id'] }}">{{ $m['name'] }} ({{ $m['member_number'] }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-slate-700 dark:text-slate-300 mb-1">Savings Amount (KES)</label>
                            <input wire:model="amountKes" type="number" step="100" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                            @error('amountKes') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block font-medium text-slate-700 dark:text-slate-300 mb-1">Welfare Amount (KES)</label>
                            <input wire:model="welfareKes" type="number" step="50" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                            @error('welfareKes') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-slate-700 dark:text-slate-300 mb-1">Payment Method</label>
                            <select wire:model="paymentMethod" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                                <option value="mpesa">M-Pesa Paybill</option>
                                <option value="bank_transfer">NCBA / Equity Bank</option>
                                <option value="cash">Cash in Hand</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-slate-700 dark:text-slate-300 mb-1">M-Pesa / Bank Reference</label>
                            <input wire:model="transactionRef" type="text" placeholder="e.g. QHL998124" class="w-full px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white uppercase font-mono">
                            @error('transactionRef') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="p-3 bg-slate-50 dark:bg-slate-800 rounded-lg flex items-center justify-between text-xs">
                        <span>Total Payable for Member:</span>
                        <span class="font-bold text-red-600 text-base">KES {{ number_format($amountKes + $welfareKes) }}</span>
                    </div>

                    <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition-colors text-sm">
                        Submit Contribution to MariaDB
                    </button>
                </form>
            </div>
        @endif

        <!-- Tab 3: Loans -->
        @if($activeTab === 'loans')
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs sm:text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-[11px] font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Loan Code</th>
                                <th class="px-6 py-3">Borrower</th>
                                <th class="px-6 py-3">Loan Type</th>
                                <th class="px-6 py-3 text-right">Principal</th>
                                <th class="px-6 py-3 text-right">Total Repayable</th>
                                <th class="px-6 py-3 text-right">Remaining Balance</th>
                                <th class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($loans as $l)
                                <tr>
                                    <td class="px-6 py-4 font-mono font-medium">{{ $l['loan_code'] }}</td>
                                    <td class="px-6 py-4 font-semibold text-slate-900 dark:text-white">{{ $l['member_name'] }}</td>
                                    <td class="px-6 py-4">{{ $l['type'] }}</td>
                                    <td class="px-6 py-4 text-right">KES {{ number_format($l['principal_kes']) }}</td>
                                    <td class="px-6 py-4 text-right">KES {{ number_format($l['repayable_kes']) }}</td>
                                    <td class="px-6 py-4 text-right font-bold text-red-600">KES {{ number_format($l['balance_kes']) }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 dark:bg-blue-950 dark:text-blue-400">{{ $l['status'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
