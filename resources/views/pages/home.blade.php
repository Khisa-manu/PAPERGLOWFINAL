@extends('layouts.app')

@section('content')
<div class="space-y-24 py-8">

    <!-- ========================================================
         SECTION 1: HERO SECTION
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-900/50">
                    <span class="w-2 h-2 rounded-full bg-red-600"></span>
                    <span>The All-In-One Kenyan Enterprise Operating System</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-heading text-slate-900 dark:text-white tracking-tight leading-[1.12]">
                    Essential Business Software & <span class="text-red-600">Custom Physical Branding</span> in One Place.
                </h1>

                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
                    Stop juggling separate software subscriptions and freelance printers. Paperglow unites your daily operational workflows (Chama, Clinic, School, Rent, POS, Invoicing) with premium company apparel and branded merchandise under a single account.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('apps.chama') }}" class="px-6 py-3.5 text-base font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm hover:shadow transition-all inline-flex items-center gap-2">
                        <span>Launch App Workspaces</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ url('/branding') }}" class="px-6 py-3.5 text-base font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-750 rounded-lg transition-all">
                        Explore Physical Branding
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-6 pt-6 border-t border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400">
                    <div>
                        <div class="text-2xl font-bold font-heading text-slate-900 dark:text-white">KES 0</div>
                        <div class="text-xs">Setup or Onboarding Fees</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold font-heading text-slate-900 dark:text-white">12+</div>
                        <div class="text-xs">Turnkey Business Apps</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold font-heading text-slate-900 dark:text-white">100%</div>
                        <div class="text-xs">PHP 8.3 & MariaDB Native</div>
                    </div>
                </div>
            </div>

            <!-- Hero Live App Preview Card -->
            <div class="lg:col-span-5">
                <div class="paperglow-panel shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800">
                    <div class="bg-slate-900 text-white px-4 py-3 flex items-center justify-between border-b border-slate-800 text-xs">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                            <span class="ml-2 font-mono text-slate-400">Paperglow Enterprise Suite v2.4</span>
                        </div>
                        <span class="text-emerald-400 font-semibold">Live Production</span>
                    </div>

                    <div class="p-6 space-y-5 bg-white dark:bg-slate-900">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xs uppercase tracking-wider text-slate-400 font-bold">Active Workspace</span>
                                <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">Ushirika Bora Chama</h3>
                            </div>
                            <span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-400 rounded-md">Reconciled</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                                <span class="text-slate-500 block mb-1">Total Group Savings</span>
                                <span class="text-base font-bold text-slate-900 dark:text-white">KES 1,245,000</span>
                            </div>
                            <div class="p-3 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                                <span class="text-slate-500 block mb-1">Active Loan Book</span>
                                <span class="text-base font-bold text-red-600">KES 480,000</span>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex items-center justify-between p-2 rounded bg-slate-50 dark:bg-slate-800">
                                <span class="font-medium">Wanjiku Kamau (UB-001)</span>
                                <span class="text-emerald-600 font-bold">+KES 5,500</span>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded bg-slate-50 dark:bg-slate-800">
                                <span class="font-medium">Brian Ochieng (UB-002)</span>
                                <span class="text-emerald-600 font-bold">+KES 5,500</span>
                            </div>
                        </div>

                        <a href="{{ route('apps.chama') }}" class="block w-full py-2.5 text-center text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                            Open Full Interactive Livewire Workspace &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================
         SECTION 2: VALUE PROPOSITION PILLARS
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
            <h2 class="text-xs uppercase font-bold tracking-wider text-red-600">Why Paperglow Beats Separate Tools</h2>
            <p class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white">One Unified Architecture For Your Entire Organization</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="paperglow-panel p-8 space-y-4 hover:border-red-300 dark:hover:border-red-900 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-red-50 dark:bg-red-950/50 flex items-center justify-center text-red-600 text-xl font-bold">
                    01
                </div>
                <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Single Unified Account</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Say goodbye to 10 different passwords and separate vendor invoices. Your team signs in once and accesses everything: patient records, Chama books, rent ledger, or corporate merchandise orders.
                </p>
            </div>

            <div class="paperglow-panel p-8 space-y-4 hover:border-red-300 dark:hover:border-red-900 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-red-50 dark:bg-red-950/50 flex items-center justify-center text-red-600 text-xl font-bold">
                    02
                </div>
                <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Zero Vendor Juggling</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Need new branded uniforms for your clinic or school, laser-engraved flasks for corporate gifts, or point-of-sale thermal receipts? Order directly inside Paperglow with guaranteed color consistency.
                </p>
            </div>

            <div class="paperglow-panel p-8 space-y-4 hover:border-red-300 dark:hover:border-red-900 transition-colors">
                <div class="w-12 h-12 rounded-lg bg-red-50 dark:bg-red-950/50 flex items-center justify-center text-red-600 text-xl font-bold">
                    03
                </div>
                <h3 class="font-heading font-bold text-xl text-slate-900 dark:text-white">Transparent Kenya Shillings</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    No unpredictable US dollar currency conversion spikes. All applications, storage tiers, and physical branding packages are transparently priced in KES with native M-Pesa and bank deposit support.
                </p>
            </div>
        </div>
    </section>

    <!-- ========================================================
         SECTION 3: APPLICATIONS SUITE SHOWCASE
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <h2 class="text-xs uppercase font-bold tracking-wider text-red-600 mb-2">Enterprise Software Suite</h2>
                <p class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white">Ready-To-Run Business Workspaces</p>
            </div>
            <a href="{{ url('/apps') }}" class="text-sm font-semibold text-red-600 hover:text-red-700 inline-flex items-center gap-1.5">
                <span>View Full 12+ Applications Directory</span> &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredApps as $app)
                <div class="paperglow-panel p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">{{ $app['category'] }}</span>
                            <span class="text-xs font-semibold text-red-600 bg-red-50 dark:bg-red-950/40 px-2 py-0.5 rounded border border-red-100 dark:border-red-900/40">{{ $app['badge'] }}</span>
                        </div>
                        <h3 class="font-heading font-bold text-lg text-slate-900 dark:text-white">{{ $app['name'] }}</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">{{ $app['description'] }}</p>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-500">{{ $app['stats'] }}</span>
                        <a href="{{ route($app['route']) }}" class="px-3.5 py-1.5 text-xs font-semibold text-white bg-red-600 hover:bg-red-700 rounded-md transition-colors">
                            Open Workspace
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================================
         SECTION 4: CUSTOM PHYSICAL BRANDING & MERCHANDISE
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-900 text-white rounded-2xl p-8 sm:p-12 overflow-hidden relative">
            <div class="max-w-3xl space-y-6">
                <span class="text-xs font-bold uppercase tracking-wider text-red-500">Physical Branding Powerhouse</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold font-heading text-white">Your Brand On Fabrics, Metals & Packaging.</h2>
                <p class="text-sm text-slate-300 leading-relaxed">
                    Paperglow operates state-of-the-art Japanese embroidery machines, precision CO2 & fiber laser engravers, and high-speed UV-DTF transfer printers. Bring your school uniforms, clinic scrubs, corporate merchandise, and retail boxes to life.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                    @foreach($brandingShowcase as $item)
                        <div class="p-4 rounded-xl bg-slate-800/80 border border-slate-700 space-y-1.5">
                            <h4 class="font-heading font-semibold text-sm text-white">{{ $item['title'] }}</h4>
                            <p class="text-xs text-slate-400">{{ $item['subtitle'] }}</p>
                            <div class="flex items-center gap-4 text-[11px] text-red-400 font-medium pt-1">
                                <span>⚡ {{ $item['turnaround'] }}</span>
                                <span>📦 {{ $item['moq'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-4">
                    <a href="{{ url('/branding') }}" class="px-6 py-3 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg inline-flex items-center gap-2">
                        <span>Launch Physical Merchandise Builder</span> &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================
         SECTION 5: UNIFIED ACCOUNT & SINGLE SIGN-ON
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="paperglow-panel p-8 sm:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-red-600">Universal Access Architecture</span>
                    <h2 class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white">Single Sign-On Across All 12 Workspaces</h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        One Paperglow master login gives your team contextual role-based access across Chamas, Clinics, Real Estate, and Invoicing. Permissions are enforced at the MariaDB layer with row-level tenant security.
                    </p>
                    <ul class="space-y-2.5 text-xs text-slate-700 dark:text-slate-300 font-medium">
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span> Multi-tenant database segmentation for every company
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span> Granular staff permissions: Cashier, Doctor, Bursar, Chairperson
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-emerald-600 font-bold">✓</span> Audit trails and activity timestamps for every transaction
                        </li>
                    </ul>
                </div>

                <div class="lg:col-span-6">
                    <div class="p-6 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 space-y-3">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Connected Tenant Services</div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs">
                            <span class="font-semibold text-slate-800 dark:text-white">Ushirika Bora Chama Group</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-medium">SSO Connected</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs">
                            <span class="font-semibold text-slate-800 dark:text-white">Afya Bora Family Care OPD</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-medium">SSO Connected</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs">
                            <span class="font-semibold text-slate-800 dark:text-white">Kilimani Premier Academy CBC</span>
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-medium">SSO Connected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================
         SECTION 6: CLIENT PROOF & ENTERPRISE RELIABILITY
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
        <div class="space-y-2">
            <h2 class="text-xs uppercase font-bold tracking-wider text-red-600">Enterprise Hosting Reliability</h2>
            <p class="text-3xl font-extrabold font-heading text-slate-900 dark:text-white">DirectAdmin & MariaDB Cloud Architecture</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="paperglow-panel p-6 space-y-2">
                <div class="text-3xl font-bold font-heading text-red-600">99.98%</div>
                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">Platform Uptime</div>
            </div>
            <div class="paperglow-panel p-6 space-y-2">
                <div class="text-3xl font-bold font-heading text-slate-900 dark:text-white">PHP 8.3</div>
                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">OPcache Fast Execution</div>
            </div>
            <div class="paperglow-panel p-6 space-y-2">
                <div class="text-3xl font-bold font-heading text-slate-900 dark:text-white">InnoDB</div>
                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">MariaDB Strict ACID Safety</div>
            </div>
            <div class="paperglow-panel p-6 space-y-2">
                <div class="text-3xl font-bold font-heading text-emerald-600">Zero Node</div>
                <div class="text-xs text-slate-600 dark:text-slate-400 font-medium">Pure Native PHP Production</div>
            </div>
        </div>
    </section>

    <!-- ========================================================
         SECTION 7: FINAL CALL TO ACTION & GETTING STARTED
         ======================================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-gradient-to-r from-red-600 to-red-700 text-white rounded-2xl p-8 sm:p-14 text-center space-y-6 shadow-xl">
            <h2 class="text-3xl sm:text-4xl font-extrabold font-heading">
                Ready to Upgrade Your Organization's Workflow?
            </h2>
            <p class="text-base text-red-100 max-w-2xl mx-auto leading-relaxed">
                Join over 250+ Kenyan enterprises, clinics, chamas, and schools running on Paperglow's high-speed platform. Deploy on Shujaa Host DirectAdmin in under 10 minutes.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-2">
                <a href="{{ route('apps.chama') }}" class="px-8 py-3.5 text-base font-bold text-red-600 bg-white hover:bg-red-50 rounded-lg shadow transition-colors">
                    Get Started With Paperglow Today
                </a>
                <a href="{{ url('/branding') }}" class="px-8 py-3.5 text-base font-semibold text-white border border-white/40 hover:bg-white/10 rounded-lg transition-colors">
                    Request Custom Branding Quote
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
