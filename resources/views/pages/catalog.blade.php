@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b border-slate-200 dark:border-slate-800 pb-6">
        <span class="text-xs font-bold uppercase tracking-wider text-red-600">Enterprise Applications Directory</span>
        <h1 class="text-3xl sm:text-4xl font-extrabold font-heading text-slate-900 dark:text-white mt-1">
            Essential Business Applications Suite
        </h1>
        <p class="text-sm text-slate-500 mt-2 max-w-2xl">
            Choose from Paperglow's 12+ pre-integrated business systems. Every application runs natively on PHP 8.3 & MariaDB with instant Kenyan Shilling billing and M-Pesa integration.
        </p>
    </div>

    <!-- Catalog Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($apps as $app)
            <div class="paperglow-panel p-6 flex flex-col justify-between hover:shadow-lg transition-shadow">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                            {{ $app['category'] }}
                        </span>
                        <span class="text-xs font-bold text-red-600">
                            KES {{ number_format($app['price_kes']) }}/{{ $app['billing'] }}
                        </span>
                    </div>

                    <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">
                        {{ $app['name'] }}
                    </h3>

                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ $app['description'] }}
                    </p>

                    <div class="space-y-1.5 pt-2">
                        @foreach($app['features'] as $feat)
                            <div class="flex items-center gap-2 text-xs text-slate-700 dark:text-slate-300">
                                <span class="text-emerald-500 font-bold">✓</span>
                                <span>{{ $feat }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <a href="{{ url('/apps/'.$app['slug']) }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
                        Learn More &rarr;
                    </a>
                    <a href="{{ route($app['route']) }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors">
                        Launch App
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
