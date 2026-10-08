@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="border-b border-slate-200 dark:border-slate-800 pb-6">
        <a href="{{ url('/apps') }}" class="text-xs text-red-600 font-semibold inline-flex items-center gap-1 mb-3">
            &larr; Back to Applications Suite
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-400">
                    {{ $app['category'] }}
                </span>
                <h1 class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white mt-2">
                    {{ $app['name'] }}
                </h1>
            </div>
            <div class="text-right">
                <span class="text-2xl font-bold text-red-600">KES {{ number_format($app['price_kes']) }}</span>
                <span class="text-xs text-slate-500 block">/{{ $app['billing'] }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="paperglow-panel p-6 space-y-4">
                <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Overview</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $app['description'] }}</p>
            </div>

            <div class="paperglow-panel p-6 space-y-4">
                <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Included Features</h3>
                <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                    @foreach($app['features'] as $feat)
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-500 font-bold">✓</span>
                            <span>{{ $feat }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="space-y-6">
            <div class="paperglow-panel p-6 space-y-4">
                <h4 class="font-heading font-bold text-base text-slate-900 dark:text-white">Ready to Deploy?</h4>
                <p class="text-xs text-slate-500">Instant activation in your Paperglow workspace on MariaDB.</p>
                <a href="{{ route($app['route']) }}" class="block w-full py-2.5 text-center text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                    Launch Interactive Workspace &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
