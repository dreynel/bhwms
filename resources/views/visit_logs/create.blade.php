@extends('layouts.app')

@section('title', 'Log Visit Check-In & Activity')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Log Visit Activity & GPS Capture</h1>
            <p class="text-xs text-slate-400 mt-1">Record vitals, services rendered, and live GPS location coordinates</p>
        </div>
        <a href="{{ route('visit-logs.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Logs</a>
    </div>

    <form method="POST" action="{{ route('visit-logs.store') }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf

        @if($schedule)
            <input type="hidden" name="visit_schedule_id" value="{{ $schedule->id }}">
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-xs text-emerald-300">
                <i class="fa-solid fa-link mr-1"></i> Completing Visit Schedule #{{ $schedule->id }} for <strong>{{ $schedule->resident->full_name }}</strong> ({{ $schedule->visit_type }})
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Target Resident *</label>
                <select name="resident_id" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                    <option value="">-- Choose Resident --</option>
                    @foreach($residents as $r)
                        <option value="{{ $r->id }}" {{ ($schedule && $schedule->resident_id == $r->id) || request('resident_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->full_name }} ({{ $r->household->purok ?? 'Brgy' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">BHW Worker Performing Visit *</label>
                <input type="hidden" name="bhw_user_id" value="{{ Auth::id() }}">
                <input type="text" value="{{ Auth::user()->name }} (Current User)" readonly class="w-full px-3.5 py-2.5 bg-slate-950/60 border border-slate-800 rounded-xl text-slate-400 font-semibold cursor-not-allowed">
            </div>
        </div>

        <!-- Vitals Form Grid -->
        <div class="border-t border-slate-800 pt-4 space-y-3">
            <h3 class="text-xs font-bold uppercase text-brand-400"><i class="fa-solid fa-heart-pulse mr-1"></i> Health Vitals Assessment</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                <div>
                    <label class="block text-slate-400 mb-1">Blood Pressure (BP)</label>
                    <input type="text" name="vitals_bp" placeholder="e.g. 120/80" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Weight (kg)</label>
                    <input type="number" step="0.1" name="vitals_weight_kg" placeholder="e.g. 58.5" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Temperature (&deg;C)</label>
                    <input type="number" step="0.1" name="vitals_temp_c" placeholder="e.g. 36.6" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Blood Sugar Level</label>
                    <input type="text" name="vitals_blood_sugar" placeholder="e.g. 95 mg/dL" class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white font-mono">
                </div>
            </div>
        </div>

        <!-- Health Findings & Services -->
        <div class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Services Rendered *</label>
                <input type="text" name="services_rendered" required placeholder="e.g. Prenatal Checkup, Vitamins distribution, BP testing..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Health Observations & Notes *</label>
                <textarea name="health_notes" rows="3" required placeholder="Patient health status observations and health advice given..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500"></textarea>
            </div>
        </div>

        <!-- Follow-up Scheduler -->
        <div class="border-t border-slate-800 pt-4 space-y-3 text-xs" x-data="{ needFollowup: false }">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="follow_up_needed" value="1" x-model="needFollowup" class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-amber-500">
                <span class="font-bold text-amber-300">Requires Follow-up Visit</span>
            </label>

            <div x-show="needFollowup" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-400 mb-1">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Follow-up Purpose</label>
                    <input type="text" name="follow_up_reason" placeholder="Reason for follow-up..." class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>
            </div>
        </div>

        <!-- Geolocation Capture (Specific Objective 4) -->
        <div class="border-t border-slate-800 pt-4 space-y-3 text-xs">
            <div class="flex items-center justify-between">
                <h3 class="font-bold uppercase text-emerald-400 flex items-center space-x-2">
                    <i class="fa-solid fa-location-crosshairs text-lg"></i>
                    <span>Visit Geolocation Capture (Objective 4)</span>
                </h3>
                <span id="geoStatus" class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-500/20 text-emerald-300">Waiting for browser permission...</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div>
                    <label class="block text-slate-400 mb-1">Latitude</label>
                    <input type="text" id="visitLat" name="latitude" required readonly class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-emerald-400 font-mono font-bold">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Longitude</label>
                    <input type="text" id="visitLng" name="longitude" required readonly class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-emerald-400 font-mono font-bold">
                </div>
                <div>
                    <label class="block text-slate-400 mb-1">Reported Accuracy (meters)</label>
                    <input type="text" id="visitAcc" name="accuracy_meters" required readonly class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-slate-300 font-mono">
                </div>
            </div>

            <input type="hidden" name="geo_permission_granted" id="geoGranted" value="1">

            <button type="button" onclick="captureGPS()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl font-semibold flex items-center space-x-2">
                <i class="fa-solid fa-rotate-right"></i>
                <span>Refresh Live GPS Coordinates</span>
            </button>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800 text-xs">
            <a href="{{ route('visit-logs.index') }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white font-semibold rounded-xl shadow-lg">Save Activity & GPS Record</button>
        </div>
    </form>
</div>

<script>
function captureGPS() {
    const status = document.getElementById('geoStatus');
    if (navigator.geolocation) {
        status.innerText = "Requesting GPS signal...";
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('visitLat').value = pos.coords.latitude.toFixed(6);
            document.getElementById('visitLng').value = pos.coords.longitude.toFixed(6);
            document.getElementById('visitAcc').value = pos.coords.accuracy.toFixed(1);
            document.getElementById('geoGranted').value = "1";
            status.innerText = "GPS Location captured successfully!";
            status.className = "px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-500/20 text-emerald-300";
        }, function(err) {
            status.innerText = "GPS Error: " + err.message + " (Using fallback default coordinates)";
            status.className = "px-2 py-0.5 rounded text-[10px] font-mono bg-amber-500/20 text-amber-300";
            // Fallback default coordinates for New Lucena if denied
            document.getElementById('visitLat').value = "10.887200";
            document.getElementById('visitLng').value = "122.610800";
            document.getElementById('visitAcc').value = "5.0";
            document.getElementById('geoGranted').value = "0";
        }, { enableHighAccuracy: true, timeout: 10000 });
    } else {
        status.innerText = "Geolocation not supported";
    }
}

// Auto capture on load
document.addEventListener('DOMContentLoaded', captureGPS);
</script>
@endsection
