<!DOCTYPE html>
<html lang="en" class="h-full" x-data="{ darkMode: localStorage.getItem('theme') === 'dark', sidebarOpen: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BHWMS') - Barangay Health Worker Information Management System | New Lucena, Iloilo</title>

    <!-- Immediate Theme Initialization: Defaults to clean, official Barangay Health Light Mode -->
    <script>
        (function() {
            try {
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Pre-compiled Standalone Tailwind CSS (Instant Render, Zero-Latency, Render-Blocking) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Tailwind Config Initialization (Must be defined BEFORE CDN script) -->
    <script>
        window.tailwind = {
            config: {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            heading: ['Outfit', 'sans-serif'],
                        },
                        colors: {
                            brand: {
                                50: '#f0fdf4',
                                100: '#dcfce7',
                                200: '#bbf7d0',
                                300: '#86efac',
                                400: '#4ade80',
                                500: '#22c55e',
                                600: '#16a34a',
                                700: '#15803d',
                                800: '#166534',
                                900: '#14532d',
                                950: '#052e16',
                            },
                            ph: {
                                blue: '#0038a8',
                                navy: '#0c1a30',
                                gold: '#f59e0b',
                                sun: '#fbbf24',
                                emerald: '#059669',
                                mint: '#10b981',
                                coral: '#f43f5e',
                            }
                        }
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Smooth transitions & pristine Filipino Barangay card elevation */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        .dark .glass-card {
            background: linear-gradient(145deg, #131d31 0%, #0d1527 100%);
            border: 1px solid rgba(51, 65, 85, 0.6);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
        }
        .glass-card-hover {
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .glass-card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -5px rgba(5, 150, 105, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .dark .glass-card-hover:hover {
            border-color: rgba(16, 185, 129, 0.4);
            box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.6), 0 0 20px -4px rgba(5, 150, 105, 0.2);
        }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white !important; color: black !important; font-size: 11pt; }
            .card-box { border: 1px solid #cbd5e1 !important; background: white !important; color: black !important; box-shadow: none !important; }
            a { text-decoration: none !important; color: black !important; }
        }
    </style>
</head>
<body class="h-full flex flex-col font-sans bg-slate-50 dark:bg-[#0c1322] text-slate-800 dark:text-slate-100 antialiased selection:bg-emerald-600 selection:text-white">

    <!-- Modular Header Component -->
    @include('layouts.partials.header')

    <div class="flex-1 flex overflow-hidden">
        <!-- Modular Sidebar Component -->
        @include('layouts.partials.sidebar')

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto bg-slate-50/60 dark:bg-[#0c1322] p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    <!-- Modular SweetAlert2 Notifications & Confirmation Handler -->
    @include('layouts.partials.swal')

    @stack('scripts')
</body>
</html>
