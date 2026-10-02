@extends('layouts.app')

@section('title', $resident->full_name . ' - Resident Profile')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="font-heading text-2xl font-extrabold text-white">{{ $resident->full_name }}</h1>
                <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase bg-slate-800 text-slate-300">{{ $resident->sex }} / {{ $resident->age }} yrs old</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">
                <i class="fa-solid fa-house text-brand-400 mr-1"></i> Household: 
                <a href="{{ route('households.show', $resident->household) }}" class="text-brand-400 hover:underline font-semibold">{{ $resident->household->household_number }}</a>
                ({{ $resident->household->purok }}, Brgy. Poblacion)
            </p>
        </div>

        <div class="flex items-center space-x-2">
            <button @click="$dispatch('open-modal', 'schedule-visit-modal')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-calendar-plus mr-1"></i>
                <span>Schedule Visit</span>
            </button>
            <button @click="$dispatch('open-modal', 'log-visit-modal'); captureResidentGPS();" class="px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs shadow-md shadow-teal-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-location-crosshairs mr-1"></i>
                <span>Log Check-In</span>
            </button>
            <a href="{{ route('residents.edit', $resident) }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition">Edit Profile</a>
        </div>
    </div>

    <!-- Health Profile Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-1">
            <p class="text-slate-500 uppercase font-semibold text-[10px]">Contact & Identification</p>
            <p class="text-white font-bold text-sm"><i class="fa-solid fa-phone text-sky-400 mr-1"></i> {{ $resident->contact_number ?: 'No Phone Number' }}</p>
            <p class="text-slate-400">PhilHealth: <span class="text-slate-200 font-mono font-semibold">{{ $resident->philhealth_number ?: 'N/A' }}</span></p>
        </div>

        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-2">
            <p class="text-slate-500 uppercase font-semibold text-[10px]">Vulnerability Flags</p>
            <div class="flex flex-wrap gap-1.5">
                @forelse($resident->vulnerabilities as $v)
                    <span class="px-2.5 py-1 rounded text-xs font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30">{{ $v }}</span>
                @empty
                    <span class="text-slate-500 italic">No vulnerability flags</span>
                @endforelse
            </div>
        </div>

        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-1">
            <p class="text-slate-500 uppercase font-semibold text-[10px]">Medical Notes</p>
            <p class="text-slate-200 leading-relaxed">{{ $resident->medical_notes ?: 'No special medical notes recorded.' }}</p>
        </div>
    </div>

    <!-- Visit History & Activity Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recorded Visit Activities -->
        <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 space-y-4">
            <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-notes-medical text-emerald-400"></i>
                <span>Completed Health Activities & Vitals</span>
            </h2>

            <div class="space-y-3">
                @forelse($resident->visitLogs as $log)
                    <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-white text-sm"><i class="fa-solid fa-calendar-check text-emerald-400 mr-1"></i> {{ $log->captured_at ? $log->captured_at->format('M d, Y h:i A') : 'Recorded' }}</span>
                            <span class="font-mono text-[10px] px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300">GPS: {{ number_format($log->latitude, 4) }}, {{ number_format($log->longitude, 4) }} (&plusmn;{{ $log->accuracy_meters }}m)</span>
                        </div>
                        <p class="text-slate-300"><strong>Services:</strong> {{ $log->services_rendered }}</p>
                        <p class="text-slate-400"><strong>Findings:</strong> {{ $log->health_notes }}</p>
                        @if($log->vitals_bp || $log->vitals_weight_kg)
                            <div class="pt-1 flex gap-3 text-slate-300 font-mono text-[11px]">
                                @if($log->vitals_bp) <span>BP: <strong>{{ $log->vitals_bp }}</strong></span> @endif
                                @if($log->vitals_weight_kg) <span>Weight: <strong>{{ $log->vitals_weight_kg }}kg</strong></span> @endif
                                @if($log->vitals_temp_c) <span>Temp: <strong>{{ $log->vitals_temp_c }}&deg;C</strong></span> @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-slate-500 italic text-center py-6">No visit check-ins recorded yet.</p>
                @endforelse
            </div>
        </div>

        <!-- Scheduled Visits & Monitoring Plan -->
        <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
                    <i class="fa-solid fa-calendar-check text-sky-400"></i>
                    <span>Scheduled Health Visits & Plan</span>
                </h2>
                <a href="{{ route('visits.create') }}?resident_id={{ $resident->id }}" class="text-xs font-bold text-sky-400 hover:text-sky-300">+ Schedule Visit</a>
            </div>

            <div class="space-y-3">
                @forelse($resident->visitSchedules as $sched)
                    <div class="p-3.5 bg-slate-950 rounded-2xl border border-slate-800 text-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-slate-300"><i class="fa-regular fa-calendar mr-1"></i> {{ $sched->scheduled_date->format('M d, Y') }}</span>
                            @if($sched->status === 'completed')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 uppercase"><i class="fa-solid fa-check mr-1"></i> Completed</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-400 uppercase"><i class="fa-solid fa-clock mr-1"></i> Scheduled</span>
                            @endif
                        </div>
                        <p class="text-white font-bold">{{ strtoupper(str_replace('_', ' ', $sched->visit_type)) }}</p>
                        <p class="text-slate-400 text-[11px]">{{ $sched->notes ?: 'Routine monitoring' }} &bull; BHW: {{ $sched->bhw->name ?? 'Assigned BHW' }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 italic text-center py-6">No scheduled visits for this resident.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal: Schedule Health Visit for this Resident -->
<x-ui.modal name="schedule-visit-modal" title="Schedule Health Visit for {{ $resident->full_name }}" subtitle="Set appointment date and assigned BHW worker" icon="fa-solid fa-calendar-plus" maxWidth="2xl">
    <form method="POST" action="{{ route('visits.store') }}" class="space-y-4 text-xs">
        @csrf
        <input type="hidden" name="resident_id" value="{{ $resident->id }}">

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Target Resident</label>
            <input type="text" value="{{ $resident->full_name }} ({{ $resident->household->household_number }})" readonly class="w-full px-3.5 py-2.5 bg-slate-100 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-600 dark:text-slate-400 font-bold cursor-not-allowed">
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
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Priority *</label>
                <select name="priority" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="medium">Medium Priority</option>
                    <option value="high">High Priority</option>
                    <option value="urgent">Urgent</option>
                    <option value="low">Low Priority</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Visit Objectives & Notes</label>
            <textarea name="notes" rows="2" placeholder="Specific checkup instructions..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'schedule-visit-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Save Schedule</button>
        </div>
    </form>
</x-ui.modal>

<!-- Modal: Log Field Check-In with GPS for this Resident -->
<x-ui.modal name="log-visit-modal" title="Log Field Check-In for {{ $resident->full_name }}" subtitle="Capture health vitals and GPS coordinates" icon="fa-solid fa-location-crosshairs" maxWidth="3xl">
    <form method="POST" action="{{ route('visit-logs.store') }}" class="space-y-4 text-xs">
        @csrf
        <input type="hidden" name="resident_id" value="{{ $resident->id }}">
        <input type="hidden" name="bhw_user_id" value="{{ Auth::id() }}">

        <!-- Vitals -->
        <div class="space-y-2">
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
                    <input type="number" step="0.1" name="vitals_weight_kg" placeholder="e.g. 60.0" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
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
                <input type="text" name="services_rendered" required placeholder="e.g. Routine vitals monitoring, medicine check..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-teal-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Health Observations & Notes *</label>
                <textarea name="health_notes" rows="2" required placeholder="Patient health status observations and health advice given..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-teal-500"></textarea>
            </div>
        </div>

        <!-- Follow-up -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2" x-data="{ needFollowup: false }">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="follow_up_needed" value="1" x-model="needFollowup" class="w-4 h-4 rounded border-slate-300 text-amber-500">
                <span class="font-bold text-amber-700 dark:text-amber-400">Requires Follow-up Visit</span>
            </label>

            <div x-show="needFollowup" x-transition class="grid grid-cols-2 gap-3 pt-1">
                <div>
                    <label class="block text-slate-500 mb-1">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-slate-500 mb-1">Follow-up Reason</label>
                    <input type="text" name="follow_up_reason" placeholder="Reason..." class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white">
                </div>
            </div>
        </div>

        <!-- GPS Coordinates -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <div class="flex items-center justify-between">
                <span class="font-bold uppercase text-teal-700 dark:text-teal-400 flex items-center space-x-1.5">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>GPS Coordinates Capture</span>
                </span>
                <span id="resGeoStatus" class="px-2 py-0.5 rounded text-[10px] font-mono bg-teal-100 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800">Ready</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Latitude</label>
                    <input type="text" id="resVisitLat" name="latitude" value="10.887200" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-teal-700 dark:text-teal-400 font-mono font-bold text-xs">
                </div>
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Longitude</label>
                    <input type="text" id="resVisitLng" name="longitude" value="122.610800" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-teal-700 dark:text-teal-400 font-mono font-bold text-xs">
                </div>
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Accuracy (&plusmn;m)</label>
                    <input type="text" id="resVisitAcc" name="accuracy_meters" value="5.0" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-700 dark:text-slate-300 font-mono text-xs">
                </div>
            </div>
            <input type="hidden" name="geo_permission_granted" id="resGeoGranted" value="1">
            <button type="button" onclick="captureResidentGPS()" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-teal-50 text-slate-700 dark:text-slate-200 rounded-xl font-bold flex items-center space-x-1.5 text-xs">
                <i class="fa-solid fa-rotate-right text-teal-600"></i>
                <span>Refresh Live GPS</span>
            </button>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'log-visit-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold shadow-lg">Save Field Check-In</button>
        </div>
    </form>
</x-ui.modal>

<script>
function captureResidentGPS() {
    const status = document.getElementById('resGeoStatus');
    if (navigator.geolocation) {
        status.innerText = "Requesting signal...";
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('resVisitLat').value = pos.coords.latitude.toFixed(6);
            document.getElementById('resVisitLng').value = pos.coords.longitude.toFixed(6);
            document.getElementById('resVisitAcc').value = pos.coords.accuracy.toFixed(1);
            document.getElementById('resGeoGranted').value = "1";
            status.innerText = "GPS Captured!";
        }, function(err) {
            status.innerText = "Fallback Default";
            document.getElementById('resVisitLat').value = "10.887200";
            document.getElementById('resVisitLng').value = "122.610800";
            document.getElementById('resVisitAcc').value = "5.0";
            document.getElementById('resGeoGranted').value = "0";
        }, { enableHighAccuracy: true, timeout: 8000 });
    }
}
</script>
@endsection
