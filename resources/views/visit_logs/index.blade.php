@extends('layouts.app')

@section('title', 'Recorded Visit Activities & GPS Checks')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900 dark:text-white">Recorded Health Activities & GPS Logs</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Audit log of completed BHW field visits with coordinates & health vitals</p>
        </div>
        <div class="flex items-center space-x-2 self-start md:self-auto">
            <button @click="$dispatch('open-modal', 'log-visit-modal'); captureModalGPS();" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-location-crosshairs text-amber-300"></i>
                <span>Log Field Check-In</span>
            </button>
            <a href="{{ route('visit-logs.create') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-emerald-100 dark:hover:bg-slate-700 transition" title="Full Page Form">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white dark:bg-[#0f172a] rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-950 uppercase text-[10px] tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Date & Time</th>
                        <th class="py-3.5 px-4">Resident</th>
                        <th class="py-3.5 px-4">Purok</th>
                        <th class="py-3.5 px-4">BHW Personnel</th>
                        <th class="py-3.5 px-4">GPS Coordinates</th>
                        <th class="py-3.5 px-4">Accuracy</th>
                        <th class="py-3.5 px-4">Follow-up?</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                    @forelse($logs as $log)
                        <tr class="hover:bg-emerald-50/40 dark:hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                                {{ $log->captured_at ? $log->captured_at->format('M d, Y h:i A') : 'Recorded' }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                                <a href="{{ route('residents.show', $log->resident) }}" class="hover:underline text-emerald-700 dark:text-emerald-400">{{ $log->resident->full_name }}</a>
                            </td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-semibold">{{ $log->resident->household->purok ?? 'N/A' }}</span></td>
                            <td class="py-3.5 px-4 font-medium text-slate-700 dark:text-slate-300">{{ $log->bhw->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 font-mono text-emerald-600 dark:text-emerald-400 font-bold">
                                <i class="fa-solid fa-location-dot mr-1 text-emerald-500"></i>
                                {{ number_format($log->latitude, 5) }}, {{ number_format($log->longitude, 5) }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-600 dark:text-slate-300">&plusmn;{{ $log->accuracy_meters }}m</td>
                            <td class="py-3.5 px-4">
                                @if($log->follow_up_needed)
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800">YES ({{ $log->follow_up_date ? $log->follow_up_date->format('M d') : 'Pending' }})</span>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500 font-medium">No</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('visit-logs.show', $log) }}" class="text-emerald-700 dark:text-emerald-400 hover:text-emerald-600 font-bold">View Details &rarr;</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-500 italic">No visit activity logs recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<!-- Modular Quick Log Field Check-In Modal with Geolocation -->
<x-ui.modal name="log-visit-modal" title="Log Field Visit Check-In & GPS" subtitle="Record health vitals, services, and live coordinates" icon="fa-solid fa-location-crosshairs" maxWidth="3xl">
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
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">BHW Performing Visit *</label>
                <input type="text" value="{{ Auth::user()->name }} (Current User)" readonly class="w-full px-3.5 py-2.5 bg-slate-100 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-500 font-semibold cursor-not-allowed">
            </div>
        </div>

        <!-- Health Vitals -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <h4 class="font-bold uppercase text-emerald-700 dark:text-emerald-400 text-xs flex items-center space-x-1.5">
                <i class="fa-solid fa-heart-pulse"></i>
                <span>Health Vitals Assessment</span>
            </h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 mb-1">Blood Pressure (BP)</label>
                    <input type="text" name="vitals_bp" placeholder="e.g. 120/80" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 mb-1">Weight (kg)</label>
                    <input type="number" step="0.1" name="vitals_weight_kg" placeholder="e.g. 58.5" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 mb-1">Temperature (&deg;C)</label>
                    <input type="number" step="0.1" name="vitals_temp_c" placeholder="e.g. 36.6" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 mb-1">Blood Sugar Level</label>
                    <input type="text" name="vitals_blood_sugar" placeholder="e.g. 95 mg/dL" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono">
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Services Rendered *</label>
                <input type="text" name="services_rendered" required placeholder="e.g. Prenatal Checkup, Vitamins distribution, BP testing..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Health Observations & Notes *</label>
                <textarea name="health_notes" rows="2" required placeholder="Observations, health advice given..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500"></textarea>
            </div>
        </div>

        <!-- Follow-up -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2" x-data="{ needFollowup: false }">
            <label class="flex items-center space-x-2 cursor-pointer">
                <input type="checkbox" name="follow_up_needed" value="1" x-model="needFollowup" class="w-4 h-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                <span class="font-bold text-amber-700 dark:text-amber-400">Requires Follow-up Visit</span>
            </label>

            <div x-show="needFollowup" x-transition class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 mb-1">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-slate-500 dark:text-slate-400 mb-1">Follow-up Purpose</label>
                    <input type="text" name="follow_up_reason" placeholder="Reason for follow-up..." class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white">
                </div>
            </div>
        </div>

        <!-- GPS Coordinates -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <div class="flex items-center justify-between">
                <span class="font-bold uppercase text-emerald-700 dark:text-emerald-400 flex items-center space-x-1.5">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>GPS Coordinates Capture</span>
                </span>
                <span id="modalGeoStatus" class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">Ready</span>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Latitude</label>
                    <input type="text" id="modalVisitLat" name="latitude" value="10.887200" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-emerald-700 dark:text-emerald-400 font-mono font-bold text-xs">
                </div>
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Longitude</label>
                    <input type="text" id="modalVisitLng" name="longitude" value="122.610800" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-emerald-700 dark:text-emerald-400 font-mono font-bold text-xs">
                </div>
                <div>
                    <label class="block text-slate-500 text-[10px] mb-0.5">Accuracy (&plusmn;m)</label>
                    <input type="text" id="modalVisitAcc" name="accuracy_meters" value="5.0" required readonly class="w-full px-2.5 py-1.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-700 dark:text-slate-300 font-mono text-xs">
                </div>
            </div>
            <input type="hidden" name="geo_permission_granted" id="modalGeoGranted" value="1">
            <button type="button" onclick="captureModalGPS()" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 text-slate-700 dark:text-slate-200 rounded-xl font-bold flex items-center space-x-1.5 text-xs">
                <i class="fa-solid fa-rotate-right text-emerald-600"></i>
                <span>Refresh Live GPS</span>
            </button>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'log-visit-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Save Field Check-In</button>
        </div>
    </form>
</x-ui.modal>

<script>
function captureModalGPS() {
    const status = document.getElementById('modalGeoStatus');
    if (navigator.geolocation) {
        status.innerText = "Requesting signal...";
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('modalVisitLat').value = pos.coords.latitude.toFixed(6);
            document.getElementById('modalVisitLng').value = pos.coords.longitude.toFixed(6);
            document.getElementById('modalVisitAcc').value = pos.coords.accuracy.toFixed(1);
            document.getElementById('modalGeoGranted').value = "1";
            status.innerText = "GPS Captured!";
        }, function(err) {
            status.innerText = "Fallback Default (Poblacion)";
            document.getElementById('modalVisitLat').value = "10.887200";
            document.getElementById('modalVisitLng').value = "122.610800";
            document.getElementById('modalVisitAcc').value = "5.0";
            document.getElementById('modalGeoGranted').value = "0";
        }, { enableHighAccuracy: true, timeout: 8000 });
    }
}
</script>
@endsection
