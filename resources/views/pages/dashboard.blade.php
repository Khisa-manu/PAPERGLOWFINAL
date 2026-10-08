@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2 py-0.5 text-xs font-semibold rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400">Single Sign-On Portal</span>
                <span class="text-xs text-slate-500">Tenant: Paperglow Enterprise Kenya</span>
            </div>
            <h1 class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white">
                Client Workspace Hub
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <span class="text-xs px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium">
                Admin: admin@paperglow.co.ke
            </span>
        </div>
    </div>

    <!-- Connected Workspaces Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($subscribedApps as $sub)
            <div class="paperglow-panel p-6 flex flex-col justify-between hover:border-red-400 dark:hover:border-red-900 transition-all">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $sub['badge'] }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $sub['metric'] }}</span>
                    </div>

                    <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">
                        {{ $sub['name'] }}
                    </h3>

                    <p class="text-xs text-slate-500">
                        {{ $sub['description'] }}
                    </p>
                </div>

                <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-xs font-medium text-slate-400">MariaDB Synchronized</span>
                    <a href="{{ route($sub['route']) }}" class="px-4 py-2 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition-colors">
                        Launch &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
