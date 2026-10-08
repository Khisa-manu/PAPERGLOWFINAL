<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Paperglow — Essential Business Applications & Custom Physical Branding' }}</title>
    <meta name="description" content="The unified platform bringing essential business applications and professional physical branding services together under one single Paperglow account.">
    
    <!-- OpenGraph -->
    <meta property="og:title" content="Paperglow — Business Applications & Custom Branding">
    <meta property="og:description" content="Single sign-on for Chama, Clinic, School, Property, POS, and Corporate Branding in Kenya.">
    <meta property="og:type" content="website">

    <!-- Fonts: DM Sans & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Poppins:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (DirectAdmin Standalone / CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#DC2626', // Paperglow signature red
                            50: '#FEF2F2',
                            100: '#FEE2E2',
                            500: '#EF4444',
                            600: '#DC2626',
                            700: '#B91C1C',
                            800: '#991B1B',
                            900: '#7F1D1D',
                        },
                        base: {
                            DEFAULT: '#ffffff',
                            dark: '#0b0d11',
                        },
                        surface: {
                            DEFAULT: '#f8fafc',
                            dark: '#12151b',
                        }
                    },
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        heading: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js for instantaneous UI interactions (dropdowns, modals, tabs) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        .paperglow-panel {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.625rem;
        }
        .dark .paperglow-panel {
            background-color: #11141a;
            border-color: #21262d;
        }
        .hairline-b { border-bottom: 1px solid #e2e8f0; }
        .dark .hairline-b { border-bottom: 1px solid #21262d; }
    </style>
</head>
<body class="bg-[#fcfdfd] dark:bg-[#0b0d11] text-[#090a0f] dark:text-[#f8fafc] font-sans antialiased min-h-screen flex flex-col selection:bg-red-600 selection:text-white">

    <!-- Top Paperglow Banner -->
    <div class="bg-red-600 text-white text-xs font-medium py-1.5 px-4 text-center">
        <span>🇰🇪 Unified Multi-Tenant Cloud Architecture — Powered by Laravel 11, Livewire 3 & MariaDB on DirectAdmin / Shujaa Host</span>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 bg-white/95 dark:bg-[#11141a]/95 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo & Brand -->
                <div class="flex items-center gap-8">
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white shadow-sm font-bold text-lg font-heading">
                            P
                        </div>
                        <div class="flex flex-col">
                            <span class="font-heading font-bold text-lg leading-tight tracking-tight text-slate-900 dark:text-white">Paperglow</span>
                            <span class="text-[10px] text-slate-500 uppercase tracking-wider font-semibold">Business OS & Branding</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
                        <a href="{{ url('/') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">Home</a>
                        <a href="{{ url('/apps') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">Applications Suite</a>
                        <a href="{{ url('/branding') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">Physical Branding</a>
                        <a href="{{ url('/dashboard') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-500 transition-colors">Client Portal</a>
                    </nav>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    <!-- Dark mode toggle -->
                    <button @click="darkMode = !darkMode" type="button" class="p-2 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Toggle theme">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </button>

                    <!-- DirectAdmin / MariaDB Status Badge -->
                    <div class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>MariaDB Active</span>
                    </div>

                    <!-- Primary Action -->
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg shadow-sm transition-colors">
                        Launch Workspace
                    </a>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden p-2 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-[#11141a] px-4 py-3 space-y-2">
            <a href="{{ url('/') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">Home</a>
            <a href="{{ url('/apps') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">Applications Suite</a>
            <a href="{{ url('/branding') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">Physical Branding</a>
            <a href="{{ url('/dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">Client Portal</a>
        </div>
    </header>

    <!-- Main Content Slot -->
    <main class="flex-1">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-sm mt-16 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded bg-red-600 flex items-center justify-center text-white font-bold text-sm">P</div>
                        <span class="font-heading font-bold text-white text-lg">Paperglow</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        The unified operating system and physical branding partner for Kenyan businesses, chamas, clinics, and property managers.
                    </p>
                    <div class="text-xs text-slate-400 space-y-1">
                        <div>Nairobi, Kenya • +254 700 123 456</div>
                        <div>DirectAdmin Host: Shujaa Host Kenya</div>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3 text-xs uppercase tracking-wider">Business Apps</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('apps.chama') }}" class="hover:text-white transition-colors">Chama & Sacco Manager</a></li>
                        <li><a href="{{ route('apps.clinic') }}" class="hover:text-white transition-colors">Clinic & OPD Manager</a></li>
                        <li><a href="{{ route('apps.school') }}" class="hover:text-white transition-colors">School & Academy Manager</a></li>
                        <li><a href="{{ route('apps.property') }}" class="hover:text-white transition-colors">Property & Rent Manager</a></li>
                        <li><a href="{{ route('apps.invoice') }}" class="hover:text-white transition-colors">Smart Invoice & Quotations</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3 text-xs uppercase tracking-wider">Physical Branding</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ url('/branding') }}" class="hover:text-white transition-colors">Corporate Uniforms & Polos</a></li>
                        <li><a href="{{ url('/branding') }}" class="hover:text-white transition-colors">Laser-Engraved Drinkware</a></li>
                        <li><a href="{{ url('/branding') }}" class="hover:text-white transition-colors">Executive Planners & Notebooks</a></li>
                        <li><a href="{{ url('/branding') }}" class="hover:text-white transition-colors">Retail Die-Cut Packaging</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-3 text-xs uppercase tracking-wider">Production Architecture</h4>
                    <ul class="space-y-1.5 text-xs text-slate-400">
                        <li><span class="text-slate-300">Backend:</span> Laravel 11 (PHP 8.3)</li>
                        <li><span class="text-slate-300">Server-Side UI:</span> Blade Templates</li>
                        <li><span class="text-slate-300">Reactivity:</span> Livewire 3 + Alpine.js</li>
                        <li><span class="text-slate-300">Database:</span> MariaDB / MySQL</li>
                        <li><span class="text-slate-300">Server:</span> DirectAdmin / Shujaa Host</li>
                        <li><span class="text-emerald-400 font-medium">✓ Zero Node.js in Production</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400">
                <p>&copy; {{ date('Y') }} Paperglow Kenya. All rights reserved.</p>
                <p>Designed for fast deployment on Kenyan DirectAdmin web hosting.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
