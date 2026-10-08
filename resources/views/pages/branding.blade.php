@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">
    <div class="border-b border-slate-200 dark:border-slate-800 pb-6">
        <span class="text-xs font-bold uppercase tracking-wider text-red-600">Paperglow Merch & Print Division</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white mt-1">
            Custom Physical Branding & Uniforms
        </h1>
        <p class="text-sm text-slate-500 mt-2 max-w-2xl">
            Order premium corporate apparel, laser-engraved merchandise, and custom retail packaging directly inside Paperglow. Delivered throughout Nairobi and across Kenya.
        </p>
    </div>

    <!-- Product Showcase with Alpine.js Quote Estimator -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8" x-data="{
        selectedProduct: 'Corporate Executive Pique Polo Shirts',
        unitPrice: 1450,
        quantity: 25,
        brandingType: 'embroidery',
        calculateTotal() {
            let total = this.quantity * this.unitPrice;
            if (this.brandingType === 'embroidery') total += 1500; // Setup fee
            return total;
        }
    }">
        <!-- Products List -->
        <div class="space-y-4">
            <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Select Product to Customize</h3>
            @foreach($products as $prod)
                <div @click="selectedProduct = '{{ $prod['name'] }}'; unitPrice = {{ $prod['price_kes'] }}; quantity = Math.max(quantity, {{ $prod['min_qty'] }});"
                     :class="{ 'border-red-600 ring-1 ring-red-600': selectedProduct === '{{ $prod['name'] }}' }"
                     class="paperglow-panel p-5 cursor-pointer hover:border-slate-400 transition-all space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">{{ $prod['category'] }}</span>
                        <span class="text-xs font-bold text-red-600">From KES {{ number_format($prod['price_kes']) }}/pc</span>
                    </div>
                    <h4 class="font-heading font-bold text-base text-slate-900 dark:text-white">{{ $prod['name'] }}</h4>
                    <div class="text-xs text-slate-500 flex flex-wrap gap-2">
                        @foreach($prod['features'] as $f)
                            <span>• {{ $f }}</span>
                        @endforeach
                    </div>
                    <div class="text-[11px] text-slate-400 font-medium">Min Order: {{ $prod['min_qty'] }} pcs</div>
                </div>
            @endforeach
        </div>

        <!-- Live Quote Builder (Alpine.js) -->
        <div>
            <div class="paperglow-panel p-6 sm:p-8 space-y-6 sticky top-24">
                <div class="border-b border-slate-200 dark:border-slate-800 pb-4">
                    <span class="text-xs text-red-600 font-bold uppercase tracking-wider">Instant Quote Estimator</span>
                    <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white mt-1" x-text="selectedProduct"></h3>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-medium mb-1 text-slate-700 dark:text-slate-300">Order Quantity (Pieces)</label>
                        <input x-model.number="quantity" type="number" min="10" step="5" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-bold text-base">
                    </div>

                    <div>
                        <label class="block font-medium mb-1 text-slate-700 dark:text-slate-300">Customization Technique</label>
                        <select x-model="brandingType" class="w-full px-3 py-2 rounded border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white">
                            <option value="embroidery">High-Density 3D Embroidery (Polos & Caps)</option>
                            <option value="laser">Precision Fiber Laser Engraving (Drinkware & Pens)</option>
                            <option value="uv_dtf">Ultra-Vivid UV-DTF Full Color Transfer</option>
                            <option value="deboss">Blind Deboss / Gold Foil Stamping (Planners)</option>
                        </select>
                    </div>

                    <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-800 space-y-2">
                        <div class="flex justify-between text-slate-500">
                            <span>Base Rate:</span>
                            <span>KES <span x-text="unitPrice"></span> &times; <span x-text="quantity"></span> pcs</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Setup & Digitization:</span>
                            <span x-text="brandingType === 'embroidery' ? 'KES 1,500' : 'Included'"></span>
                        </div>
                        <div class="border-t border-slate-200 dark:border-slate-700 pt-2 flex justify-between font-bold text-sm text-slate-900 dark:text-white">
                            <span>Estimated Total:</span>
                            <span class="text-red-600 text-lg">KES <span x-text="calculateTotal().toLocaleString()"></span></span>
                        </div>
                    </div>

                    <button @click="alert('Quote request received! Our production desk will contact you via WhatsApp with digital mockups.')" type="button" class="w-full py-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition-colors">
                        Submit Order / Request Proof Mockup
                    </button>

                    <p class="text-[11px] text-slate-400 text-center">
                        ✓ Free digital proof within 3 business hours • Delivery available across Kenya
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
