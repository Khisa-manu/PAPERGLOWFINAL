<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-red-100 text-red-700 dark:bg-red-950/60 dark:text-red-400">Smart Invoicing</span>
                <span class="text-xs text-slate-500">16% KRA VAT Auto-Calculation</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-heading text-slate-900 dark:text-white">Tax Invoice & Quotation Generator</h1>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" type="button" class="px-4 py-2 text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-white rounded-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>Print / Save as PDF</span>
            </button>
        </div>
    </div>

    <!-- The Printable Invoice Sheet -->
    <div class="paperglow-panel p-8 sm:p-12 shadow-sm space-y-8 bg-white dark:bg-slate-900">
        <!-- Top Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6 border-b border-slate-200 dark:border-slate-800 pb-8">
            <div>
                <div class="flex items-center gap-2.5 mb-2">
                    <div class="w-8 h-8 rounded bg-red-600 flex items-center justify-center text-white font-bold font-heading text-lg">P</div>
                    <span class="font-heading font-extrabold text-xl text-slate-900 dark:text-white">Paperglow Kenya Ltd</span>
                </div>
                <div class="text-xs text-slate-500 space-y-0.5">
                    <div>P.O. Box 48210 - 00100 Nairobi, Kenya</div>
                    <div>KRA PIN: <strong>P051982736M</strong> • VAT Registered</div>
                    <div>Email: accounts@paperglow.co.ke • Tel: +254 700 123 456</div>
                </div>
            </div>

            <div class="sm:text-right space-y-1">
                <span class="text-xs uppercase font-bold text-red-600 tracking-wider">Document Type</span>
                <select wire:model.live="documentType" class="block sm:ml-auto text-sm font-bold border border-slate-200 dark:border-slate-700 rounded px-2 py-1 bg-transparent">
                    <option value="Tax Invoice">TAX INVOICE</option>
                    <option value="Proforma Invoice">PROFORMA INVOICE</option>
                    <option value="Official Quotation">OFFICIAL QUOTATION</option>
                </select>
                <div class="text-xs font-mono text-slate-600 dark:text-slate-400">No: {{ $invoiceNumber }}</div>
                <div class="text-xs text-slate-500">Date: {{ $issueDate }} • Due: {{ $dueDate }}</div>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Billed Client / Organization</span>
                <input wire:model.live="clientName" type="text" class="w-full font-bold text-sm bg-transparent border-b border-slate-300 dark:border-slate-700 py-1 focus:outline-none focus:border-red-600">
                <input wire:model.live="clientKraPin" placeholder="Client KRA PIN (e.g. P051123456Z)" type="text" class="w-full text-slate-600 dark:text-slate-400 bg-transparent border-b border-slate-200 dark:border-slate-800 py-0.5 focus:outline-none">
                <input wire:model.live="clientAddress" placeholder="Physical Address / Town" type="text" class="w-full text-slate-500 bg-transparent border-b border-slate-200 dark:border-slate-800 py-0.5 focus:outline-none">
            </div>

            <div class="sm:text-right space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Payment Routing</span>
                <div class="text-slate-700 dark:text-slate-300 font-medium">M-Pesa Paybill: <strong>247247</strong></div>
                <div class="text-slate-700 dark:text-slate-300">Account No: <strong>INV-0842</strong></div>
                <div class="text-slate-500">NCBA Bank Kenya • Westlands Branch</div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-500 uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3 text-center w-20">Qty</th>
                        <th class="px-4 py-3 text-right w-32">Rate (KES)</th>
                        <th class="px-4 py-3 text-right w-36">Total (KES)</th>
                        <th class="px-2 py-3 w-10 text-center no-print"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @foreach($items as $idx => $item)
                        <tr>
                            <td class="px-4 py-3">
                                <input wire:model.live="items.{{ $idx }}.description" type="text" class="w-full bg-transparent font-medium text-slate-900 dark:text-white focus:outline-none">
                            </td>
                            <td class="px-4 py-3 text-center">
                                <input wire:model.live="items.{{ $idx }}.quantity" type="number" min="1" class="w-16 text-center bg-transparent border border-slate-200 dark:border-slate-700 rounded py-0.5">
                            </td>
                            <td class="px-4 py-3 text-right">
                                <input wire:model.live="items.{{ $idx }}.unit_price" type="number" step="10" class="w-28 text-right bg-transparent border border-slate-200 dark:border-slate-700 rounded py-0.5">
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-slate-900 dark:text-white">
                                {{ number_format($item['quantity'] * $item['unit_price'], 2) }}
                            </td>
                            <td class="px-2 py-3 text-center no-print">
                                <button wire:click="removeItem({{ $idx }})" type="button" class="text-red-500 hover:text-red-700">&times;</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="no-print">
            <button wire:click="addItem" type="button" class="px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded">
                + Add Item Line
            </button>
        </div>

        <!-- Totals Calculation -->
        <div class="flex flex-col sm:flex-row justify-between gap-6 pt-4 border-t border-slate-200 dark:border-slate-800 text-xs">
            <div class="max-w-md space-y-2">
                <span class="font-bold text-slate-700 dark:text-slate-300 block">Terms & Remittance:</span>
                <p class="text-slate-500 italic">{{ $notes }}</p>
                <div class="flex items-center gap-2 pt-2 no-print">
                    <label class="flex items-center gap-1.5 cursor-pointer">
                        <input wire:model.live="includeVat" type="checkbox" class="rounded text-red-600">
                        <span>Apply 16% VAT</span>
                    </label>
                </div>
            </div>

            <div class="sm:w-64 space-y-2">
                <div class="flex justify-between text-slate-600 dark:text-slate-400">
                    <span>Subtotal:</span>
                    <span>KES {{ number_format($subtotal, 2) }}</span>
                </div>
                @if($includeVat)
                    <div class="flex justify-between text-slate-600 dark:text-slate-400">
                        <span>16% Value Added Tax:</span>
                        <span>KES {{ number_format($vatAmount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-base text-slate-900 dark:text-white pt-2 border-t border-slate-300 dark:border-slate-700">
                    <span>Total Payable:</span>
                    <span class="text-red-600">KES {{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
