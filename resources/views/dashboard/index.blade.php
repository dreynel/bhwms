@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <!-- Philippine LGU Barangay Official Banner -->
    <div class="relative overflow-hidden p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-[#0038a8] via-[#047857] to-[#065f46] border border-emerald-500/30 shadow-xl flex flex-col lg:flex-row lg:items-center justify-between gap-6 text-white">
        <!-- Festive sunburst glow accents -->
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 bg-emerald-300/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="space-y-3.5 relative z-10">
            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-300/40 text-amber-200 text-xs font-black uppercase tracking-wider shadow-sm">
                <i class="fa-solid fa-sun text-amber-300"></i>
                <span>BARANGAY HEALTH STATION &bull; PUBLIC HEALTH SERVICE</span>
            </div>
            <h1 class="font-heading text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight drop-shadow-sm">
                Barangay {{ $setting->barangay_name ?? 'Poblacion' }} Health Management System
            </h1>
            <p class="text-emerald-100 text-sm font-semibold max-w-xl">
                Barangay Health Worker Information Management System (BHWMS) for community wellness and healthcare monitoring.
            </p>
            <div class="flex flex-wrap items-center gap-y-1 gap-x-3 text-xs text-emerald-100 font-medium pt-1">
                <span class="flex items-center"><i class="fa-solid fa-location-dot text-amber-300 mr-1.5"></i> Municipality of {{ $setting->municipality ?? 'New Lucena' }}, Province of {{ $setting->province ?? 'Iloilo' }}</span>
                <span class="text-emerald-300">&bull;</span>
                <span class="text-amber-200 font-bold"><i class="fa-solid fa-user-shield mr-1"></i> Barangay Captain: {{ $setting->captain_name ?? 'Hon. Jose R. Maravilla' }}</span>
            </div>
        </div>

        <div class="flex flex-wrap gap-2.5 relative z-10 self-start lg:self-auto">
            <button @click="$dispatch('open-modal', 'dash-schedule-modal')" class="px-4 py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shadow-lg shadow-amber-900/30 flex items-center space-x-2 transition hover:scale-105">
                <i class="fa-solid fa-calendar-plus text-sm"></i>
                <span>Schedule Health Visit</span>
            </button>
            <button @click="$dispatch('open-modal', 'dash-log-modal'); captureDashGPS();" class="px-4 py-3 rounded-2xl bg-white hover:bg-emerald-50 text-emerald-800 font-black text-xs shadow-lg shadow-emerald-950/20 flex items-center space-x-2 transition hover:scale-105">
                <i class="fa-solid fa-location-crosshairs text-sm text-emerald-600"></i>
                <span>Log Field Check-In</span>
            </button>
            <button @click="$dispatch('open-modal', 'dash-household-modal')" class="px-4 py-3 rounded-2xl bg-emerald-900/60 hover:bg-emerald-900/80 border border-emerald-400/40 text-white font-black text-xs shadow-md flex items-center space-x-2 transition hover:scale-105">
                <i class="fa-solid fa-house-chimney-medical text-sm text-emerald-300"></i>
                <span>New Household</span>
            </button>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Households -->
        <div class="glass-card glass-card-hover p-5 rounded-2xl flex items-center justify-between border-t-4 border-t-emerald-600">
            <div>
                <p class="text-[11px] font-black uppercase text-slate-500 dark:text-slate-400 tracking-wider">Registered Households</p>
                <h3 class="font-heading text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalHouseholds) }}</h3>
                <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold mt-1 flex items-center">
                    <i class="fa-solid fa-circle-check mr-1.5 text-emerald-600"></i> Purok 1 to Purok 7 Masterlist
                </p>
            </div>
            <div class="w-13 h-13 p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-2xl shadow-sm">
                <i class="fa-solid fa-house-chimney-user"></i>
            </div>
        </div>

        <!-- Residents -->
        <div class="glass-card glass-card-hover p-5 rounded-2xl flex items-center justify-between border-t-4 border-t-blue-600">
            <div>
                <p class="text-[11px] font-black uppercase text-slate-500 dark:text-slate-400 tracking-wider">Residents Masterlist</p>
                <h3 class="font-heading text-3xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalResidents) }}</h3>
                <p class="text-[11px] text-blue-700 dark:text-blue-400 font-bold mt-1 flex items-center">
                    <i class="fa-solid fa-id-card mr-1.5 text-blue-600"></i> PhilHealth & Health Records
                </p>
            </div>
            <div class="w-13 h-13 p-3.5 rounded-2xl bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800 flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl shadow-sm">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Visit Schedules -->
        <div class="glass-card glass-card-hover p-5 rounded-2xl flex items-center justify-between border-t-4 border-t-amber-500">
            <div>
                <p class="text-[11px] font-black uppercase text-slate-500 dark:text-slate-400 tracking-wider">Pending Visit Schedules</p>
                <h3 class="font-heading text-3xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ number_format($pendingVisits) }}</h3>
                <p class="text-[11px] text-slate-600 dark:text-slate-300 font-bold mt-1">
                    <i class="fa-solid fa-circle-check text-emerald-600 mr-1"></i> {{ number_format($completedVisits) }} Visits Completed
                </p>
            </div>
            <div class="w-13 h-13 p-3.5 rounded-2xl bg-amber-50 dark:bg-amber-950/50 border border-amber-200 dark:border-amber-800 flex items-center justify-center text-amber-600 dark:text-amber-400 text-2xl shadow-sm">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
        </div>

        <!-- Active BHW Personnel -->
        <div class="glass-card glass-card-hover p-5 rounded-2xl flex items-center justify-between border-t-4 border-t-indigo-600">
            <div>
                <p class="text-[11px] font-black uppercase text-slate-500 dark:text-slate-400 tracking-wider">Active BHW Personnel</p>
                <h3 class="font-heading text-3xl font-black text-indigo-700 dark:text-indigo-400 mt-1">{{ number_format($totalBhws) }}</h3>
                <p class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold mt-1 flex items-center">
                    <i class="fa-solid fa-clipboard-check mr-1.5 text-emerald-600"></i> {{ number_format($pendingFollowups) }} Follow-ups Needed
                </p>
            </div>
            <div class="w-13 h-13 p-3.5 rounded-2xl bg-indigo-50 dark:bg-indigo-950/50 border border-indigo-200 dark:border-indigo-800 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl shadow-sm">
                <i class="fa-solid fa-user-nurse"></i>
            </div>
        </div>
    </div>

    <!-- Vulnerability Health Profile Summary -->
    <div class="glass-card p-6 rounded-3xl space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-heading text-base sm:text-lg font-extrabold text-slate-900 dark:text-white flex items-center space-x-2.5">
                <div class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <span>Special Health Sectors & Vulnerability Masterlist</span>
            </h2>
            <a href="{{ route('residents.index') }}" class="text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:text-emerald-600 hover:underline">
                Full Registry &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3.5">
            <a href="{{ route('residents.index', ['vulnerability' => 'pregnant']) }}" class="p-4 bg-pink-50/70 dark:bg-pink-950/20 rounded-2xl border border-pink-200 dark:border-pink-800/60 hover:border-pink-400 transition group shadow-sm">
                <div class="flex items-center justify-between text-pink-600 dark:text-pink-400">
                    <p class="text-[11px] font-extrabold uppercase tracking-wider">Maternal / Pregnant</p>
                    <i class="fa-solid fa-person-pregnant text-lg"></i>
                </div>
                <p class="font-heading text-2xl font-black text-pink-700 dark:text-pink-300 mt-2">{{ $pregnantCount }}</p>
                <p class="text-[10px] text-pink-600 font-semibold mt-0.5">Prenatal Care</p>
            </a>

            <a href="{{ route('residents.index', ['vulnerability' => 'infant']) }}" class="p-4 bg-sky-50/70 dark:bg-sky-950/20 rounded-2xl border border-sky-200 dark:border-sky-800/60 hover:border-sky-400 transition group shadow-sm">
                <div class="flex items-center justify-between text-sky-600 dark:text-sky-400">
                    <p class="text-[11px] font-extrabold uppercase tracking-wider">Infant & Child (EPI)</p>
                    <i class="fa-solid fa-baby text-lg"></i>
                </div>
                <p class="font-heading text-2xl font-black text-sky-700 dark:text-sky-300 mt-2">{{ $infantCount }}</p>
                <p class="text-[10px] text-sky-600 font-semibold mt-0.5">Ages 0-5 Years</p>
            </a>

            <a href="{{ route('residents.index', ['vulnerability' => 'senior']) }}" class="p-4 bg-amber-50/70 dark:bg-amber-950/20 rounded-2xl border border-amber-200 dark:border-amber-800/60 hover:border-amber-400 transition group shadow-sm">
                <div class="flex items-center justify-between text-amber-600 dark:text-amber-400">
                    <p class="text-[11px] font-extrabold uppercase tracking-wider">Senior Citizens (60+)</p>
                    <i class="fa-solid fa-person-walking-with-cane text-lg"></i>
                </div>
                <p class="font-heading text-2xl font-black text-amber-700 dark:text-amber-300 mt-2">{{ $seniorCount }}</p>
                <p class="text-[10px] text-amber-600 font-semibold mt-0.5">Ages 60 & Above</p>
            </a>

            <a href="{{ route('residents.index', ['vulnerability' => 'pwd']) }}" class="p-4 bg-purple-50/70 dark:bg-purple-950/20 rounded-2xl border border-purple-200 dark:border-purple-800/60 hover:border-purple-400 transition group shadow-sm">
                <div class="flex items-center justify-between text-purple-600 dark:text-purple-400">
                    <p class="text-[11px] font-extrabold uppercase tracking-wider">PWD Beneficiaries</p>
                    <i class="fa-solid fa-wheelchair text-lg"></i>
                </div>
                <p class="font-heading text-2xl font-black text-purple-700 dark:text-purple-300 mt-2">{{ $pwdCount }}</p>
                <p class="text-[10px] text-purple-600 font-semibold mt-0.5">Special Assistance</p>
            </a>

            <a href="{{ route('residents.index', ['vulnerability' => 'hypertension']) }}" class="p-4 bg-rose-50/70 dark:bg-rose-950/20 rounded-2xl border border-rose-200 dark:border-rose-800/60 hover:border-rose-400 transition group shadow-sm">
                <div class="flex items-center justify-between text-rose-600 dark:text-rose-400">
                    <p class="text-[11px] font-extrabold uppercase tracking-wider">Hypertension / Diabetes</p>
                    <i class="fa-solid fa-heart-circle-bolt text-lg"></i>
                </div>
                <p class="font-heading text-2xl font-black text-rose-700 dark:text-rose-300 mt-2">{{ $chronicCount }}</p>
                <p class="text-[10px] text-rose-600 font-semibold mt-0.5">Maintenance Medicine</p>
            </a>
        </div>
    </div>

    <!-- Recent Completed Visits & GPS Coordinates Table -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Completed Visits with Location -->
        <div class="glass-card p-6 rounded-3xl space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-heading text-base font-extrabold text-slate-900 dark:text-white flex items-center space-x-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-map-pin"></i>
                    </div>
                    <span>Recent Field Check-Ins & GPS Location</span>
                </h2>
                <a href="{{ route('map.index') }}" class="text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:text-emerald-600 hover:underline">Map View &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentVisits as $visit)
                    <div class="p-4 bg-slate-50 dark:bg-[#0f172a] rounded-2xl border border-slate-200 dark:border-slate-800 flex items-start justify-between text-xs hover:border-emerald-400 dark:hover:border-emerald-500/40 transition">
                        <div class="space-y-1">
                            <p class="font-bold text-slate-900 dark:text-white text-sm">{{ $visit->resident->full_name }}</p>
                            <p class="text-slate-600 dark:text-slate-300 font-medium"><i class="fa-solid fa-user-nurse text-emerald-600 dark:text-emerald-400 mr-1"></i> BHW: {{ $visit->bhw->name }}</p>
                            <p class="text-slate-500 dark:text-slate-400 text-[11px]"><i class="fa-regular fa-clock mr-1 text-slate-400"></i> {{ $visit->captured_at ? $visit->captured_at->format('M d, Y h:i A') : 'Recorded' }}</p>
                        </div>
                        <div class="text-right space-y-1">
                            <span class="inline-block px-2.5 py-1 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 font-mono text-[11px] border border-emerald-300 dark:border-emerald-800 font-bold">
                                {{ number_format($visit->latitude, 5) }}, {{ number_format($visit->longitude, 5) }}
                            </span>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">GPS Accuracy: <span class="text-slate-800 dark:text-white font-bold">&plusmn;{{ $visit->accuracy_meters }}m</span></p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 italic text-center py-6">No field visit check-ins recorded yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Schedules -->
        <div class="glass-card p-6 rounded-3xl space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-heading text-base font-extrabold text-slate-900 dark:text-white flex items-center space-x-2">
                    <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <span>Upcoming Visit Schedules</span>
                </h2>
                <a href="{{ route('visits.index') }}" class="text-xs font-bold text-amber-700 dark:text-amber-400 hover:text-amber-600 hover:underline">All Schedules &rarr;</a>
            </div>

            <div class="space-y-3">
                @forelse($recentSchedules as $sched)
                    <div class="p-4 bg-slate-50 dark:bg-[#0f172a] rounded-2xl border border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs hover:border-amber-400 dark:hover:border-amber-500/40 transition">
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $sched->resident->full_name }}</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800">{{ str_replace('_', ' ', $sched->visit_type) }}</span>
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 font-medium"><i class="fa-regular fa-calendar text-amber-600 dark:text-amber-400 mr-1"></i> {{ $sched->scheduled_date->format('M d, Y') }}</p>
                        </div>

                        <span class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-amber-700 dark:text-amber-300 font-bold text-[11px] flex items-center space-x-1.5 shadow-sm">
                            <i class="fa-regular fa-clock text-amber-500"></i>
                            <span>{{ ucfirst($sched->status) }}</span>
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 italic text-center py-6">No upcoming visits scheduled.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal: Quick Schedule Health Visit -->
<x-ui.modal name="dash-schedule-modal" title="Quick Schedule Health Visit" subtitle="Assign health checkup, immunization, or monitoring" icon="fa-solid fa-calendar-plus" maxWidth="2xl">
    <form method="POST" action="{{ route('visits.store') }}" class="space-y-4 text-xs">
        @csrf
        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Target Resident *</label>
            <select name="resident_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                <option value="">-- Choose Resident --</option>
                @foreach($residents as $r)
                    <option value="{{ $r->id }}">
                        {{ $r->full_name }} ({{ $r->household->purok ?? 'Brgy' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Assigned BHW Personnel *</label>
            <select name="bhw_user_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                <option value="">-- Select BHW --</option>
                @foreach($bhws as $b)
                    <option value="{{ $b->id }}" {{ Auth::id() == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->purok ?? 'BHS' }})</option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Scheduled Date *</label>
                <input type="date" name="scheduled_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Scheduled Time</label>
                <input type="time" name="scheduled_time" value="09:00" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Service Type *</label>
                <select name="visit_type" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="routine_monitoring">Routine Household Monitoring</option>
                    <option value="maternal_checkup">Maternal / Prenatal Checkup</option>
                    <option value="child_immunization">Child Immunization</option>
                    <option value="senior_wellness">Senior Citizen Wellness</option>
                    <option value="tb_followup">TB / Communicable Follow-up</option>
                </select>
            </div>
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Priority Level *</label>
                <select name="priority" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="medium">Medium Priority</option>
                    <option value="high">High Priority</option>
                    <option value="urgent">Urgent</option>
                    <option value="low">Low Priority</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Notes / Instructions</label>
            <textarea name="notes" rows="2" placeholder="Field instructions for BHW..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'dash-schedule-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold shadow-lg">Save Schedule</button>
        </div>
    </form>
</x-ui.modal>

<!-- Modal: Quick Log Field Check-In with GPS -->
<x-ui.modal name="dash-log-modal" title="Quick Field Check-In & GPS Capture" subtitle="Record health vitals, services, and live coordinates" icon="fa-solid fa-location-crosshairs" maxWidth="3xl">
    <form method="POST" action="{{ route('visit-logs.store') }}" class="space-y-4 text-xs">
        @csrf
        <input type="hidden" name="bhw_user_id" value="{{ Auth::id() }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Target Resident *</label>
                <select name="resident_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="">-- Choose Resident --</option>
                    @foreach($residents as $r)
                        <option value="{{ $r->id }}">
                            {{ $r->full_name }} ({{ $r->household->purok ?? 'Brgy' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">BHW Performing Check-In *</label>
                <input type="text" value="{{ Auth::user()->name }} (Current User)" readonly class="w-full px-3.5 py-2.5 bg-slate-100 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-500 font-semibold cursor-not-allowed">
            </div>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <h4 class="font-bold uppercase text-emerald-700 dark:text-emerald-400 text-xs flex items-center space-x-1.5">
                <i class="fa-solid fa-heart-pulse"></i>
                <span>Health Vitals Assessment</span>
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-slate-500 mb-1">Blood Pressure</label>
                    <input type="text" name="vitals_bp" placeholder="e.g. 120/80" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-500 mb-1">Weight (kg)</label>
                    <input type="number" step="0.1" name="vitals_weight_kg" placeholder="e.g. 55.0" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-500 mb-1">Temperature (&deg;C)</label>
                    <input type="number" step="0.1" name="vitals_temp_c" placeholder="e.g. 36.5" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-500 mb-1">Blood Sugar</label>
                    <input type="text" name="vitals_blood_sugar" placeholder="e.g. 95 mg/dL" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Services Rendered *</label>
                <input type="text" name="services_rendered" required placeholder="e.g. Health visit, BP check, medicine distribution..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Health Observations & Notes *</label>
                <textarea name="health_notes" rows="2" required placeholder="Observations..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500"></textarea>
            </div>
        </div>

        <!-- GPS Coordinates -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <div class="flex items-center justify-between">
                <span class="font-bold uppercase text-emerald-700 dark:text-emerald-400 flex items-center space-x-1.5">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>GPS Coordinates Capture</span>
                </span>
                <span id="dashGeoStatus" class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">Ready</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Latitude</label>
                    <input type="text" id="dashVisitLat" name="latitude" value="10.887200" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-emerald-700 dark:text-emerald-400 font-mono font-bold text-xs">
                </div>
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Longitude</label>
                    <input type="text" id="dashVisitLng" name="longitude" value="122.610800" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-emerald-700 dark:text-emerald-400 font-mono font-bold text-xs">
                </div>
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Accuracy (&plusmn;m)</label>
                    <input type="text" id="dashVisitAcc" name="accuracy_meters" value="5.0" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-700 dark:text-slate-300 font-mono text-xs">
                </div>
            </div>
            <input type="hidden" name="geo_permission_granted" id="dashGeoGranted" value="1">
            <button type="button" onclick="captureDashGPS()" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 text-slate-700 dark:text-slate-200 rounded-xl font-bold flex items-center space-x-1.5 text-xs">
                <i class="fa-solid fa-rotate-right text-emerald-600"></i>
                <span>Refresh Live GPS</span>
            </button>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'dash-log-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Save Check-In</button>
        </div>
    </form>
</x-ui.modal>

<!-- Modal: Quick Register Household -->
<x-ui.modal name="dash-household-modal" title="Quick Household Registration" subtitle="Register a new household unit for Barangay Poblacion" icon="fa-solid fa-house-chimney-medical" maxWidth="3xl">
    <form method="POST" action="{{ route('households.store') }}" class="space-y-4 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Household Number *</label>
                <input type="text" name="household_number" value="HH-{{ date('Y') }}-{{ rand(1000, 9999) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Head of Family Full Name *</label>
                <input type="text" name="head_name" placeholder="e.g., Juan Dela Cruz" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Purok / Zone *</label>
                <select name="purok" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="Purok 1">Purok 1</option>
                    <option value="Purok 2">Purok 2</option>
                    <option value="Purok 3">Purok 3</option>
                    <option value="Purok 4">Purok 4</option>
                    <option value="Purok 5">Purok 5</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Street Address</label>
                <input type="text" name="address" placeholder="Brgy. Poblacion, New Lucena" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Sanitary Toilet Type</label>
                <select name="sanitary_toilet" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="Water-sealed / Flush Toilet">Water-sealed / Flush Toilet</option>
                    <option value="Pit Latrine">Pit Latrine</option>
                    <option value="None / Shared">None / Shared</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Water Source Level</label>
                <select name="water_source" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="Level III (Piped tap into household)">Level III (Piped tap into household)</option>
                    <option value="Level II (Communal faucet)">Level II (Communal faucet)</option>
                    <option value="Level I (Point source / Deep well)">Level I (Point source / Deep well)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-2">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">GPS Latitude (Optional)</label>
                <input type="number" step="any" name="latitude" value="10.8875" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
            </div>
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">GPS Longitude (Optional)</label>
                <input type="number" step="any" name="longitude" value="122.6108" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'dash-household-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Save Household</button>
        </div>
    </form>
</x-ui.modal>

<script>
function captureDashGPS() {
    const status = document.getElementById('dashGeoStatus');
    if (navigator.geolocation) {
        status.innerText = "Requesting signal...";
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('dashVisitLat').value = pos.coords.latitude.toFixed(6);
            document.getElementById('dashVisitLng').value = pos.coords.longitude.toFixed(6);
            document.getElementById('dashVisitAcc').value = pos.coords.accuracy.toFixed(1);
            document.getElementById('dashGeoGranted').value = "1";
            status.innerText = "GPS Captured!";
        }, function(err) {
            status.innerText = "Fallback Default";
            document.getElementById('dashVisitLat').value = "10.887200";
            document.getElementById('dashVisitLng').value = "122.610800";
            document.getElementById('dashVisitAcc').value = "5.0";
            document.getElementById('dashGeoGranted').value = "0";
        }, { enableHighAccuracy: true, timeout: 8000 });
    }
}
</script>
@endsection
