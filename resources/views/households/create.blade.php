@extends('layouts.app')

@section('title', 'Register Household')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Register Household Profile</h1>
            <p class="text-xs text-slate-400 mt-1">Add household information & sanitary facilities survey</p>
        </div>
        <a href="{{ route('households.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Registry</a>
    </div>

    <form method="POST" action="{{ route('households.store') }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Household Number *</label>
                <input type="text" name="household_number" value="{{ old('household_number', 'HH-POB-' . sprintf('%03d', rand(10, 999))) }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Head of Family Name *</label>
                <input type="text" name="head_name" value="{{ old('head_name') }}" required placeholder="e.g. Juan Dela Cruz" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Purok / Sitio *</label>
                <select name="purok" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    @foreach($puroks as $p)
                        <option value="{{ $p }}">{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Income Bracket</label>
                <select name="income_bracket" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Low-Income / NTHP">Low-Income / NTHP</option>
                    <option value="4Ps Beneficiary">4Ps Beneficiary</option>
                    <option value="Middle Class">Middle Class</option>
                    <option value="High Income">High Income</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Water Source Type</label>
                <select name="water_source" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Level III - Waterworks System">Level III - Waterworks System</option>
                    <option value="Level II - Communal Faucet">Level II - Communal Faucet</option>
                    <option value="Level I - Protected Well">Level I - Protected Well</option>
                    <option value="Unprotected Source">Unprotected Source</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Sanitary Toilet Facility</label>
                <select name="sanitary_toilet" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Water-sealed Sanitary Toilet">Water-sealed Sanitary Toilet</option>
                    <option value="Pour Flush Toilet">Pour Flush Toilet</option>
                    <option value="Communal Toilet">Communal Toilet</option>
                    <option value="Insanitary / No Toilet">Insanitary / No Toilet</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Address Details / Sitio</label>
            <input type="text" name="address_details" value="{{ old('address_details') }}" placeholder="Street, Sitio, or Landmark in Poblacion" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
        </div>

        <div class="border-t border-slate-800 pt-4 space-y-3">
            <h3 class="text-xs font-bold uppercase text-brand-400"><i class="fa-solid fa-location-crosshairs mr-1"></i> Optional Map Pin Coordinates</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Latitude</label>
                    <input type="text" id="latInput" name="latitude" value="{{ old('latitude', '10.887200') }}" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Longitude</label>
                    <input type="text" id="lngInput" name="longitude" value="{{ old('longitude', '122.610800') }}" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono">
                </div>
            </div>
            <button type="button" onclick="getLocation()" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 rounded-lg">
                <i class="fa-solid fa-crosshairs mr-1"></i> Get Current GPS Location
            </button>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
            <a href="{{ route('households.index') }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white font-semibold text-xs rounded-xl shadow-lg">Save Household Profile</button>
        </div>
    </form>
</div>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById('latInput').value = pos.coords.latitude.toFixed(6);
            document.getElementById('lngInput').value = pos.coords.longitude.toFixed(6);
            alert("Current location set successfully!");
        }, function(err) {
            alert("Geolocation error: " + err.message);
        });
    } else {
        alert("Geolocation is not supported by your browser.");
    }
}
</script>
@endsection
