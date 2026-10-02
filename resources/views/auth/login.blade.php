<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Barangay Health Worker Information Management System | New Lucena, Iloilo</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Pre-compiled Standalone Tailwind CSS (Instant Render) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Tailwind Config Initialization -->
    <script>
        window.tailwind = {
            config: {
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
                                500: '#22c55e',
                                600: '#16a34a',
                                700: '#15803d',
                            },
                            ph: {
                                blue: '#0038a8',
                                navy: '#0c1a30',
                                gold: '#f59e0b',
                                sun: '#fbbf24',
                                emerald: '#059669',
                                mint: '#10b981',
                            }
                        }
                    }
                }
            }
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-full flex flex-col items-center justify-center p-4 bg-gradient-to-br from-emerald-50 via-slate-50 to-blue-50/70 dark:from-[#0a1424] dark:via-[#0f172a] dark:to-[#062c1d] font-sans relative antialiased selection:bg-emerald-600 selection:text-white">

    <!-- Ambient Community Glow -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-400/15 dark:bg-emerald-600/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-500/15 dark:bg-blue-600/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Official Portal Card -->
    <div class="w-full max-w-md bg-white dark:bg-[#10192d] rounded-3xl border border-slate-200 dark:border-slate-800 shadow-2xl shadow-emerald-950/10 relative overflow-hidden z-10 transition duration-300">
        <!-- Philippine Tricolor Top Accent Ribbon -->
        <div class="h-2 w-full bg-gradient-to-r from-blue-700 via-amber-400 to-emerald-600"></div>

        <div class="p-6 sm:p-8 space-y-6">
            <!-- Official Seal Header -->
            <div class="text-center space-y-3">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-500 to-blue-700 p-0.5 shadow-lg shadow-emerald-900/20">
                    <div class="w-full h-full rounded-[14px] bg-slate-900 flex items-center justify-center border border-amber-400/60">
                        <i class="fa-solid fa-heart-pulse text-2xl text-emerald-400 animate-pulse"></i>
                    </div>
                </div>
                <div>
                    <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 text-[10px] font-black uppercase tracking-wider border border-emerald-300 dark:border-emerald-700/60 mb-1.5">
                        <i class="fa-solid fa-sun text-amber-500 mr-1"></i>
                        <span>Republic of the Philippines &bull; Iloilo</span>
                    </div>
                    <h1 class="font-heading text-2xl font-black text-slate-900 dark:text-white tracking-tight">BARANGAY POBLACION</h1>
                    <p class="text-xs text-emerald-700 dark:text-emerald-400 font-bold uppercase tracking-wider">Health Worker Information Management System</p>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Municipality of New Lucena &bull; Rural Health Unit Partner</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="p-3.5 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="flex items-center"><i class="fa-solid fa-circle-exclamation mr-1.5 text-rose-500"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label for="email" class="block font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Official Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <i class="fa-solid fa-envelope text-emerald-600"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email', 'admin@newlucena.gov.ph') }}" required autofocus class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-[#0c1424] border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition font-medium">
                    </div>
                </div>

                <div>
                    <label for="password" class="block font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">System Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                            <i class="fa-solid fa-lock text-amber-500"></i>
                        </span>
                        <input type="password" id="password" name="password" value="password" required class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-[#0c1424] border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-500/20 transition font-medium">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-600 dark:text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span>Remember me on this browser</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-xs rounded-xl shadow-lg shadow-emerald-700/25 uppercase tracking-wider transition duration-200 flex items-center justify-center space-x-2 transform hover:-translate-y-0.5">
                    <span>Access Barangay Portal</span>
                    <i class="fa-solid fa-arrow-right-to-bracket text-amber-300"></i>
                </button>
            </form>

            <!-- Quick Demo Credentials for Defense Panel & Teachers -->
            <div class="border-t border-slate-200 dark:border-slate-800 pt-4 space-y-2">
                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-extrabold text-center uppercase tracking-wider">
                    <i class="fa-solid fa-hand-pointer text-emerald-600 mr-1"></i> Quick Demo Login (Click to test):
                </p>
                <div class="grid grid-cols-2 gap-1.5 text-[11px]">
                    <button type="button" onclick="fillForm('admin@newlucena.gov.ph', this)" class="demo-btn px-2.5 py-1.5 rounded-lg bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-300 hover:bg-amber-100 transition font-bold text-left flex items-center space-x-1.5">
                        <i class="fa-solid fa-user-shield text-amber-600"></i>
                        <span class="truncate">Barangay Captain (Admin)</span>
                    </button>
                    <button type="button" onclick="fillForm('supervisor@newlucena.gov.ph', this)" class="demo-btn px-2.5 py-1.5 rounded-lg bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800 text-blue-900 dark:text-blue-300 hover:bg-blue-100 transition font-bold text-left flex items-center space-x-1.5">
                        <i class="fa-solid fa-stethoscope text-blue-600"></i>
                        <span class="truncate">Health Supervisor</span>
                    </button>
                    <button type="button" onclick="fillForm('bhw1@newlucena.gov.ph', this)" class="demo-btn px-2.5 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-300 hover:bg-emerald-100 transition font-bold text-left flex items-center space-x-1.5">
                        <i class="fa-solid fa-user-nurse text-emerald-600"></i>
                        <span class="truncate">BHW Ana (Purok 1-2)</span>
                    </button>
                    <button type="button" onclick="fillForm('bhw2@newlucena.gov.ph', this)" class="demo-btn px-2.5 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-300 hover:bg-emerald-100 transition font-bold text-left flex items-center space-x-1.5">
                        <i class="fa-solid fa-user-nurse text-emerald-600"></i>
                        <span class="truncate">BHW Maria (Purok 3-4)</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="px-6 py-3 bg-slate-50 dark:bg-[#0c1424] border-t border-slate-200 dark:border-slate-800 text-center">
            <p class="text-[10px] text-slate-500 font-semibold">
                Dedicated public service for community health &bull; DOH Aligned
            </p>
        </div>
    </div>

    <script>
        function fillForm(email, btn) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';

            document.querySelectorAll('.demo-btn').forEach(b => {
                b.classList.remove('ring-2', 'ring-emerald-500');
            });
            if (btn) {
                btn.classList.add('ring-2', 'ring-emerald-500');
            }
        }
    </script>
</body>
</html>
