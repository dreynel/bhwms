@extends('layouts.app')

@section('title', 'Edit Household ' . $household->household_number)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Edit Household Profile</h1>
            <p class="text-xs text-slate-400 mt-1">{{ $household->household_number }} - {{ $household->head_name }}</p>
        </div>
        <a href="{{ route('households.show', $household) }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Details</a>
    </div>

    <form method="POST" action="{{ route('households.update', $household) }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Household Number *</label>
                <input type="text" name="household_number" value="{{ old('household_number', $household->household_number) }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Head of Family Name *</label>
                <input type="text" name="head_name" value="{{ old('head_name', $household->head_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Purok / Sitio *</label>
                <select name="purok" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    @foreach($puroks as $p)
                        <option value="{{ $p }}" {{ $household->purok == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Income Bracket</label>
                <select name="income_bracket" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Low-Income / NTHP" {{ $household->income_bracket == 'Low-Income / NTHP' ? 'selected' : '' }}>Low-Income / NTHP</option>
                    <option value="4Ps Beneficiary" {{ $household->income_bracket == '4Ps Beneficiary' ? 'selected' : '' }}>4Ps Beneficiary</option>
                    <option value="Middle Class" {{ $household->income_bracket == 'Middle Class' ? 'selected' : '' }}>Middle Class</option>
                    <option value="High Income" {{ $household->income_bracket == 'High Income' ? 'selected' : '' }}>High Income</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Water Source Type</label>
                <select name="water_source" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Level III - Waterworks System" {{ $household->water_source == 'Level III - Waterworks System' ? 'selected' : '' }}>Level III - Waterworks System</option>
                    <option value="Level II - Communal Faucet" {{ $household->water_source == 'Level II - Communal Faucet' ? 'selected' : '' }}>Level II - Communal Faucet</option>
                    <option value="Level I - Protected Well" {{ $household->water_source == 'Level I - Protected Well' ? 'selected' : '' }}>Level I - Protected Well</option>
                    <option value="Unprotected Source" {{ $household->water_source == 'Unprotected Source' ? 'selected' : '' }}>Unprotected Source</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Sanitary Toilet Facility</label>
                <select name="sanitary_toilet" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Water-sealed Sanitary Toilet" {{ $household->sanitary_toilet == 'Water-sealed Sanitary Toilet' ? 'selected' : '' }}>Water-sealed Sanitary Toilet</option>
                    <option value="Pour Flush Toilet" {{ $household->sanitary_toilet == 'Pour Flush Toilet' ? 'selected' : '' }}>Pour Flush Toilet</option>
                    <option value="Communal Toilet" {{ $household->sanitary_toilet == 'Communal Toilet' ? 'selected' : '' }}>Communal Toilet</option>
                    <option value="Insanitary / No Toilet" {{ $household->sanitary_toilet == 'Insanitary / No Toilet' ? 'selected' : '' }}>Insanitary / No Toilet</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Address Details / Sitio</label>
            <input type="text" name="address_details" value="{{ old('address_details', $household->address_details) }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
        </div>

        <div class="border-t border-slate-800 pt-4 space-y-3">
            <h3 class="text-xs font-bold uppercase text-brand-400">Map Pin Coordinates</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Latitude</label>
                    <input type="text" name="latitude" value="{{ old('latitude', $household->latitude) }}" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs text-slate-400 mb-1">Longitude</label>
                    <input type="text" name="longitude" value="{{ old('longitude', $household->longitude) }}" class="w-full px-3.5 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
            <a href="{{ route('households.show', $household) }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white font-semibold text-xs rounded-xl shadow-lg">Update Household</button>
        </div>
    </form>
</div>
@endsection
