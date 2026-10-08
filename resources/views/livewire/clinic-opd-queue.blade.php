<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400">Clinic OPD Hub</span>
                <span class="text-xs text-slate-500">Livewire 3 + MariaDB</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white">Afya Bora Family Care Clinic</h1>
            <p class="text-xs sm:text-sm text-slate-500">Real-Time Patient Triage, Consultation Notes, & Pharmacy Dispense</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                In Consultation: <strong class="text-emerald-600">{{ $inConsultationCount }}</strong>
            </span>
            <span class="text-xs px-2.5 py-1 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                Waiting Doctor: <strong class="text-amber-600">{{ $waitingCount }}</strong>
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column: OPD Queue List -->
        <div class="lg:col-span-8 paperglow-panel overflow-hidden">
            <div class="bg-slate-50 dark:bg-slate-800/60 px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h3 class="font-heading font-bold text-slate-900 dark:text-white text-sm">Active Patient Queue</h3>
                <span class="text-xs text-slate-500">{{ count($queueList) }} Patients in OPD</span>
            </div>

            <div class="divide-y divide-slate-200 dark:divide-slate-800">
                @foreach($queueList as $p)
                    <div class="p-6 hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-xs font-bold font-mono bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">#{{ $p['queue_no'] }}</span>
                                <h4 class="font-heading font-bold text-slate-900 dark:text-white text-base">{{ $p['name'] }}</h4>
                                <span class="text-xs text-slate-400">({{ $p['age'] }}y, {{ $p['gender'] }})</span>
                            </div>
                            <p class="text-xs text-slate-600 dark:text-slate-400 font-medium">OPD ID: {{ $p['opd_no'] }} • Arrived: {{ $p['arrival_time'] }}</p>
                            <p class="text-xs text-slate-500 italic">Chief Complaint: "{{ $p['complaint'] }}"</p>
                            <div class="flex items-center gap-3 text-xs pt-1">
                                <span class="font-medium text-slate-600 dark:text-slate-400">BP: {{ $p['bp'] }}</span>
                                <span class="font-medium text-slate-600 dark:text-slate-400">Temp: {{ $p['temp'] > 0 ? $p['temp'].'°C' : '--' }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:items-end gap-2">
                            @if($p['stage'] === 'triage')
                                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-amber-50 text-amber-700 border border-amber-200">Needs Vitals</span>
                                <button wire:click="recordVitals('{{ $p['id'] }}')" class="px-3 py-1.5 text-xs font-semibold bg-emerald-600 hover:bg-emerald-700 text-white rounded transition-colors">
                                    Record Vitals &rarr;
                                </button>
                            @elseif($p['stage'] === 'waiting')
                                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-blue-50 text-blue-700 border border-blue-200">Waiting Doctor</span>
                                <button wire:click="advanceStage('{{ $p['id'] }}', 'in_consultation')" class="px-3 py-1.5 text-xs font-semibold bg-red-600 hover:bg-red-700 text-white rounded transition-colors">
                                    Start Consultation
                                </button>
                            @elseif($p['stage'] === 'in_consultation')
                                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-emerald-50 text-emerald-700 border border-emerald-200">In Consultation</span>
                                <button wire:click="advanceStage('{{ $p['id'] }}', 'ready_for_billing')" class="px-3 py-1.5 text-xs font-semibold bg-slate-800 hover:bg-slate-900 text-white rounded transition-colors">
                                    Send to Billing
                                </button>
                            @else
                                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-purple-50 text-purple-700 border border-purple-200">Billing Desk</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: Fast Patient Check-In Form -->
        <div class="lg:col-span-4 paperglow-panel p-6 space-y-4">
            <div>
                <h3 class="font-heading font-bold text-slate-900 dark:text-white text-base">Register Walk-In Patient</h3>
                <p class="text-xs text-slate-500">Livewire will auto-assign queue number.</p>
            </div>

            <form wire:submit.prevent="addPatientToQueue" class="space-y-3 text-xs">
                <div>
                    <label class="block font-medium mb-1">Patient Full Name</label>
                    <input wire:model="patientName" type="text" placeholder="e.g. John Mwangi" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                    @error('patientName') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium mb-1">Phone Number</label>
                    <input wire:model="patientPhone" type="text" placeholder="+254 712 000 000" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                    @error('patientPhone') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-medium mb-1">Age</label>
                        <input wire:model="patientAge" type="number" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Gender</label>
                        <select wire:model="patientGender" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800">
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium mb-1">Chief Complaint</label>
                    <textarea wire:model="complaint" rows="3" placeholder="Symptoms, duration, acute pain..." class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800"></textarea>
                    @error('complaint') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-sm transition-colors text-xs">
                    Issue OPD Ticket & Queue
                </button>
            </form>
        </div>
    </div>
</div>
