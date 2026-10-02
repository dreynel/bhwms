<!-- Official Philippine Republic Header Stripe Module -->
<div class="no-print bg-[#0a1424] text-slate-200 border-b border-amber-500/40 px-4 py-1.5 text-[11px] flex items-center justify-between shadow-sm relative overflow-hidden">
    <!-- Tricolor hairline indicator at very top -->
    <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-blue-600 via-amber-400 to-emerald-500"></div>

    <div class="flex items-center space-x-2">
        <span class="inline-flex items-center space-x-1.5 font-bold text-amber-400 tracking-wider">
            <i class="fa-solid fa-sun text-amber-400 text-xs"></i>
            <span class="tracking-wide font-black">REPUBLIC OF THE PHILIPPINES</span>
        </span>
        <span class="text-slate-600">&bull;</span>
        <span class="text-slate-300 font-medium hidden sm:inline">Province of Iloilo &bull; Municipality of New Lucena</span>
        <span class="text-slate-600 hidden sm:inline">&bull;</span>
        <span class="text-emerald-400 font-bold">Barangay Poblacion</span>
    </div>
    <div class="flex items-center space-x-3 text-slate-300 text-[11px]">
        <span class="font-semibold text-emerald-300 flex items-center">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping mr-1.5"></span>
            <span>BHS Patrol Active</span>
        </span>
        <span class="text-slate-600">&bull;</span>
        <span class="font-mono text-amber-300 font-bold"><i class="fa-regular fa-calendar-check mr-1 text-amber-400"></i> {{ date('F d, Y') }}</span>
    </div>
</div>

<!-- Main Navigation Bar Module -->
<header class="no-print sticky top-0 z-40 bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 shadow-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Mobile Menu Toggle & Official Barangay Seal -->
            <div class="flex items-center space-x-3">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-800 transition">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3.5 group">
                    <!-- Official Barangay Health Seal Crest -->
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-600 to-blue-700 p-0.5 shadow-md shadow-emerald-900/20 group-hover:scale-105 transition duration-300">
                        <div class="w-full h-full rounded-[14px] bg-slate-900 flex items-center justify-center border border-amber-400/60">
                            <i class="fa-solid fa-heart-pulse text-emerald-400 text-lg group-hover:scale-110 transition duration-300"></i>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="font-heading font-black text-xl text-slate-900 dark:text-white tracking-tight">BHW<span class="text-emerald-600 dark:text-emerald-400">MS</span></span>
                            <span class="text-[10px] font-black px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/40 uppercase tracking-wider">
                                BARANGAY HEALTH STATION
                            </span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 tracking-wider uppercase">Barangay Poblacion Health Center &bull; New Lucena, Iloilo</p>
                    </div>
                </a>
            </div>

            <!-- Quick Notifications, Theme Switcher & User Profile Module -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <!-- Theme Toggle Button -->
                <button @click="darkMode = !darkMode; localStorage.setItem('theme', darkMode ? 'dark' : 'light')" 
                        class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-amber-300 hover:bg-emerald-50 dark:hover:bg-slate-700/80 transition shadow-sm flex items-center space-x-1.5"
                        title="Toggle Light / Dark Mode">
                    <template x-if="darkMode">
                        <span class="flex items-center text-xs font-bold text-amber-300"><i class="fa-solid fa-sun mr-1.5 text-amber-400"></i> <span class="hidden sm:inline">Light Mode</span></span>
                    </template>
                    <template x-if="!darkMode">
                        <span class="flex items-center text-xs font-bold text-slate-700"><i class="fa-solid fa-moon mr-1.5 text-blue-600"></i> <span class="hidden sm:inline">Dark Mode</span></span>
                    </template>
                </button>

                @auth
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2.5 p-1.5 pr-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 transition shadow-sm">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-600 to-teal-600 text-white font-black flex items-center justify-center text-xs shadow-md">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <span class="block font-bold text-xs text-slate-800 dark:text-slate-200 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] font-extrabold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">{{ strtoupper(Auth::user()->role) }}</span>
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-64 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl py-2 z-50">
                            <div class="px-4 py-2.5 border-b border-slate-200 dark:border-slate-800">
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase font-extrabold tracking-wider">Signed in as</p>
                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate mt-0.5">{{ Auth::user()->name }}</p>
                                <span class="inline-block mt-1 text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/40">
                                    {{ strtoupper(Auth::user()->role) }}
                                </span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" data-confirm="Are you sure you want to sign out from BHWMS?" data-confirm-title="Sign Out Confirmation" data-confirm-button="Yes, Sign Out" data-confirm-icon="question">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-xs text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-slate-800 flex items-center space-x-2 font-bold transition">
                                    <i class="fa-solid fa-right-from-bracket text-rose-500"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white shadow-md transition">Sign In</a>
                @endauth
            </div>
        </div>
    </div>
</header>
