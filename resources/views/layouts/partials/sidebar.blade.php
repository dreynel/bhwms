<!-- Sidebar Navigation Module -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="no-print fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-[#0f172a] border-r border-slate-200 dark:border-slate-800 transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto flex flex-col justify-between shadow-sm">
    <div class="py-4 px-3 space-y-1 overflow-y-auto">
        <!-- Main Directory Header -->
        <div class="px-3 py-1 text-[10px] font-black uppercase text-emerald-700 dark:text-emerald-400 tracking-wider flex items-center justify-between">
            <span>MAIN DIRECTORY</span>
            <i class="fa-solid fa-house-medical text-[10px]"></i>
        </div>
        
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            <span>Dashboard Overview</span>
        </a>

        <a href="{{ route('households.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('households.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-house-chimney-medical"></i>
            </div>
            <span>Household Profiles</span>
        </a>

        <a href="{{ route('residents.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('residents.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-users"></i>
            </div>
            <span>Resident Masterlist</span>
        </a>

        <a href="{{ route('assignments.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('assignments.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-user-nurse"></i>
            </div>
            <span>BHW Purok Assignments</span>
        </a>

        <!-- Visits & GPS Header -->
        <div class="pt-3 px-3 py-1 text-[10px] font-black uppercase text-amber-700 dark:text-amber-400 tracking-wider flex items-center justify-between">
            <span>VISITS & GPS TRACKING</span>
            <i class="fa-solid fa-location-crosshairs text-[10px]"></i>
        </div>

        <a href="{{ route('visits.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('visits.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <span>Visit Schedules</span>
        </a>

        <a href="{{ route('visit-logs.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('visit-logs.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-notes-medical"></i>
            </div>
            <span>Recorded Activities</span>
        </a>

        <a href="{{ route('map.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('map.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <span>Restricted GPS Map</span>
        </a>

        <!-- Official Reports & DOH Header -->
        <div class="pt-3 px-3 py-1 text-[10px] font-black uppercase text-blue-700 dark:text-blue-400 tracking-wider flex items-center justify-between">
            <span>REPORTS & DOH FORMS</span>
            <i class="fa-solid fa-file-medical text-[10px]"></i>
        </div>

        <a href="{{ route('reports.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('reports.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-print"></i>
            </div>
            <span>Printable LGU Summaries</span>
        </a>

        <a href="{{ route('forms.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('forms.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-file-signature"></i>
            </div>
            <span>DOH Digitized Forms</span>
        </a>

        <!-- Quality Header -->
        <div class="pt-3 px-3 py-1 text-[10px] font-black uppercase text-purple-700 dark:text-purple-400 tracking-wider flex items-center justify-between">
            <span>QUALITY & STANDARDS</span>
            <i class="fa-solid fa-award text-[10px]"></i>
        </div>

        <a href="{{ route('iso-evaluation.index') }}" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('iso-evaluation.*') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-600/60 shadow-sm' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-emerald-700 dark:hover:text-white' }}">
            <div class="w-7 h-7 rounded-lg bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xs">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <span>ISO/IEC 25010 Engine</span>
        </a>
    </div>

    <!-- Authentic Filipino Barangay Seal Footer -->
    <div class="p-3.5 border-t border-slate-200 dark:border-slate-800 text-[11px] bg-emerald-50/50 dark:bg-[#0c1322]">
        <div class="flex items-center space-x-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-shield-heart text-xs"></i>
            </div>
            <div class="leading-tight">
                <p class="font-extrabold text-slate-900 dark:text-white text-xs">Barangay Poblacion BHS</p>
                <p class="text-[10px] text-emerald-700 dark:text-emerald-400 font-semibold">New Lucena, Iloilo &bull; Public Health</p>
            </div>
        </div>
    </div>
</aside>
