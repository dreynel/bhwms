@extends('layouts.app')

@section('title', 'Restricted GPS Map View')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="font-heading text-2xl font-extrabold text-white">Restricted Visit GPS Map View</h1>
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Objective 4 Verified</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Interactive OpenStreetMap display showing saved coordinates, timestamp, and reported accuracy radius circles</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 shadow-md">
        <form method="GET" action="{{ route('map.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
            <div>
                <select name="purok" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                    <option value="">All Puroks</option>
                    @foreach($puroks as $p)
                        <option value="{{ $p }}" {{ request('purok') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="date" name="date" value="{{ request('date') }}" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
            </div>
            <div class="sm:col-span-2 flex items-center space-x-2">
                <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl transition">
                    <i class="fa-solid fa-filter mr-1"></i> Update Map View
                </button>
                @if(request()->anyFilled(['purok', 'date']))
                    <a href="{{ route('map.index') }}" class="px-3 py-2 bg-slate-950 text-slate-400 hover:text-white rounded-xl border border-slate-800"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- Leaflet Interactive Map Card -->
    <div class="bg-slate-900 p-4 rounded-3xl border border-slate-800 shadow-xl space-y-4">
        <div class="flex items-center justify-between text-xs text-slate-400">
            <span class="flex items-center space-x-2">
                <i class="fa-solid fa-earth-philippines text-emerald-400"></i>
                <span class="font-semibold text-white">Barangay Poblacion Field Visit Markers</span>
                <span>({{ $visitLogs->count() }} Geolocated Check-ins)</span>
            </span>
            <div class="flex items-center space-x-4">
                <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> <span>Verified Visit Pin</span></span>
                <span class="flex items-center space-x-1.5"><span class="w-3 h-3 rounded-full bg-sky-500"></span> <span>Accuracy Radius</span></span>
            </div>
        </div>

        <div id="map" class="w-full h-[520px] rounded-2xl border border-slate-800 z-10"></div>
    </div>

    <!-- Visit Geolocation List Grid -->
    <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 space-y-4">
        <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
            <i class="fa-solid fa-list-check text-emerald-400"></i>
            <span>Captured Coordinates Audit Log</span>
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-xs">
            @forelse($visitLogs as $log)
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800/80 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-white text-sm">{{ $log->resident->full_name }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-slate-800 text-slate-300">{{ $log->resident->household->purok ?? 'Brgy' }}</span>
                    </div>

                    <p class="text-slate-400"><i class="fa-solid fa-user-nurse text-teal-400 mr-1"></i> BHW: {{ $log->bhw->name }}</p>

                    <div class="p-2.5 rounded-xl bg-slate-900 border border-slate-800 font-mono text-[11px] space-y-1">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Latitude:</span>
                            <span class="text-emerald-400 font-bold">{{ number_format($log->latitude, 6) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Longitude:</span>
                            <span class="text-emerald-400 font-bold">{{ number_format($log->longitude, 6) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Accuracy:</span>
                            <span class="text-white">&plusmn;{{ $log->accuracy_meters }}m</span>
                        </div>
                        <div class="flex justify-between pt-1 border-t border-slate-800">
                            <span class="text-slate-500">Time:</span>
                            <span class="text-slate-300">{{ $log->captured_at ? $log->captured_at->format('M d, h:i A') : 'Recorded' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-slate-500 italic">No visit check-ins with saved GPS coordinates.</div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Center map around New Lucena, Iloilo coordinates
    const map = L.map('map').setView([{{ $centerLat }}, {{ $centerLon }}], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    @foreach($visitLogs as $v)
        @if($v->latitude && $v->longitude)
            // Add Marker
            const marker = L.marker([{{ $v->latitude }}, {{ $v->longitude }}]).addTo(map);
            
            // Add Accuracy Circle
            const circle = L.circle([{{ $v->latitude }}, {{ $v->longitude }}], {
                color: '#0284c7',
                fillColor: '#38bdf8',
                fillOpacity: 0.15,
                radius: {{ $v->accuracy_meters ?: 10 }}
            }).addTo(map);

            marker.bindPopup(`
                <div class="p-1 text-slate-900 text-xs font-sans">
                    <strong class="text-sm font-bold">${@json($v->resident->full_name)}</strong><br>
                    <span class="text-slate-600">BHW: ${@json($v->bhw->name)}</span><br>
                    <span class="text-slate-600">Purok: ${@json($v->resident->household->purok ?? 'Poblacion')}</span><br>
                    <hr class="my-1">
                    <span class="font-mono text-[11px]">Lat: ${@json(number_format($v->latitude, 5))}</span><br>
                    <span class="font-mono text-[11px]">Lng: ${@json(number_format($v->longitude, 5))}</span><br>
                    <span class="text-slate-500 text-[10px]">Accuracy: &plusmn;${@json($v->accuracy_meters)}m</span><br>
                    <span class="text-slate-500 text-[10px]">Time: ${@json($v->captured_at ? $v->captured_at->format('M d, Y h:i A') : 'Recorded')}</span>
                </div>
            `);
        @endif
    @endforeach
});
</script>
@endpush
@endsection
