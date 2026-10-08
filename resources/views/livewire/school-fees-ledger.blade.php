<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-blue-100 text-blue-700 dark:bg-blue-950 dark:text-blue-400">School & CBC Manager</span>
                <span class="text-xs text-slate-500">Livewire 3 + MariaDB</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white">Kilimani Premier Academy</h1>
            <p class="text-xs sm:text-sm text-slate-500">CBC Competency Ledger • Term Fee Invoicing • M-Pesa Paybill Reconciliations</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200">
                MoE CBC Compliant
            </span>
        </div>
    </div>

    @if($successMessage)
        <div class="p-4 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-sm flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold">✓</span>
                <span>{{ $successMessage }}</span>
            </div>
            <button wire:click="$set('successMessage', '')" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- Fee Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Term 1 Total Billed</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                KES {{ number_format($totalBilled) }}
            </div>
            <span class="text-xs text-slate-500">Tuition, Boarding & Activity Fees</span>
        </div>

        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Collected Term Fees</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-emerald-600">
                KES {{ number_format($totalPaid) }}
            </div>
            <span class="text-xs text-emerald-600 font-medium">Reconciled in MariaDB</span>
        </div>

        <div class="paperglow-panel p-6">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-1">Fee Arrears Balance</span>
            <div class="text-2xl sm:text-3xl font-extrabold font-heading text-red-600">
                KES {{ number_format($totalOutstanding) }}
            </div>
            <span class="text-xs text-red-500">Parent SMS Reminders Dispatched</span>
        </div>
    </div>

    <!-- Student Ledger Table & Record Form -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 paperglow-panel overflow-hidden">
            <div class="bg-slate-50 dark:bg-slate-800 px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="font-heading font-bold text-slate-900 dark:text-white text-sm">Grade 7 Class Register</h3>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search pupil name or Adm..." class="px-3 py-1 text-xs rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-500 uppercase text-[10px] tracking-wider">
                        <tr>
                            <th class="px-4 py-3">Adm No</th>
                            <th class="px-4 py-3">Student Name</th>
                            <th class="px-4 py-3">Guardian</th>
                            <th class="px-4 py-3 text-right">Fee Billed</th>
                            <th class="px-4 py-3 text-right">Fee Paid</th>
                            <th class="px-4 py-3 text-right">Balance</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($studentsList as $s)
                            <tr>
                                <td class="px-4 py-3 font-mono font-medium">{{ $s['admission_no'] }}</td>
                                <td class="px-4 py-3 font-bold text-slate-900 dark:text-white">{{ $s['name'] }}</td>
                                <td class="px-4 py-3 text-slate-500">{{ $s['parent_name'] }} ({{ $s['parent_phone'] }})</td>
                                <td class="px-4 py-3 text-right">KES {{ number_format($s['fee_billed_kes']) }}</td>
                                <td class="px-4 py-3 text-right text-emerald-600 font-medium">KES {{ number_format($s['fee_paid_kes']) }}</td>
                                <td class="px-4 py-3 text-right font-bold {{ $s['balance_kes'] > 0 ? 'text-red-600' : 'text-slate-400' }}">
                                    {{ $s['balance_kes'] > 0 ? 'KES '.number_format($s['balance_kes']) : 'Nil' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $s['status'] === 'Cleared' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                        {{ $s['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right: Record Fee Payment -->
        <div class="lg:col-span-4 paperglow-panel p-6 space-y-4">
            <div>
                <h3 class="font-heading font-bold text-slate-900 dark:text-white text-base">Record Fee Payment</h3>
                <p class="text-xs text-slate-500">Livewire will post to MariaDB and generate receipt.</p>
            </div>

            <form wire:submit.prevent="recordPayment" class="space-y-3 text-xs">
                <div>
                    <label class="block font-medium mb-1">Student</label>
                    <select wire:model="studentId" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                        @foreach($students as $st)
                            <option value="{{ $st['id'] }}">{{ $st['name'] }} ({{ $st['admission_no'] }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium mb-1">Amount Paid (KES)</label>
                    <input wire:model="amountKes" type="number" step="500" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                    @error('amountKes') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">M-Pesa / Bank Reference</label>
                    <input wire:model="transactionRef" type="text" placeholder="e.g. QHL887711" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 uppercase font-mono">
                    @error('transactionRef') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition-colors text-xs">
                    Generate Fee Receipt
                </button>
            </form>
        </div>
    </div>
</div>
