@extends('layouts.app')

@section('title', 'Household Profiles')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900 dark:text-white">Central Household Registry</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Barangay Poblacion, Municipality of New Lucena, Iloilo</p>
        </div>
        <div class="flex items-center space-x-2">
            <button @click="$dispatch('open-modal', 'add-household-modal')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-house-chimney-medical"></i>
                <span>Register Household</span>
            </button>
            <a href="{{ route('households.create') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-emerald-100 dark:hover:bg-slate-700 transition" title="Full Page Form">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-md">
        <form method="GET" action="{{ route('households.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search household # or head name..." class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>
            <div>
                <select name="purok" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                    <option value="">All Puroks</option>
                    @foreach($puroks as $p)
                        <option value="{{ $p }}" {{ request('purok') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl transition">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'purok']))
                    <a href="{{ route('households.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-950 text-slate-600 dark:text-slate-400 hover:text-white text-xs rounded-xl border border-slate-200 dark:border-slate-800"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- Households Data Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-950 uppercase text-[10px] tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Household #</th>
                        <th class="py-3.5 px-4">Head of Family</th>
                        <th class="py-3.5 px-4">Purok</th>
                        <th class="py-3.5 px-4">Sanitary Toilet</th>
                        <th class="py-3.5 px-4">Water Source</th>
                        <th class="py-3.5 px-4">Residents</th>
                        <th class="py-3.5 px-4">Map Location</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                    @forelse($households as $hh)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900 dark:text-white">{{ $hh->household_number }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">{{ $hh->head_name }}</td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-blue-700 dark:text-blue-300 font-semibold text-[11px]">{{ $hh->purok }}</span></td>
                            <td class="py-3.5 px-4 text-slate-600 dark:text-slate-400">{{ $hh->sanitary_toilet }}</td>
                            <td class="py-3.5 px-4 text-slate-600 dark:text-slate-400">{{ $hh->water_source }}</td>
                            <td class="py-3.5 px-4 font-bold text-teal-600 dark:text-teal-400">{{ $hh->residents_count }} member(s)</td>
                            <td class="py-3.5 px-4">
                                @if($hh->latitude && $hh->longitude)
                                    <span class="text-emerald-600 dark:text-emerald-400 font-mono text-[11px]"><i class="fa-solid fa-location-dot mr-1"></i> Pin Saved</span>
                                @else
                                    <span class="text-slate-400 dark:text-slate-500 italic">No GPS</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2">
                                <a href="{{ route('households.show', $hh) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">View</a>
                                <a href="{{ route('households.edit', $hh) }}" class="text-slate-500 hover:text-slate-900 dark:hover:text-white">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-500 italic">No household records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            {{ $households->links() }}
        </div>
    </div>
</div>

<!-- Modular Quick Add Household Modal Component -->
<x-ui.modal name="add-household-modal" title="Quick Household Registration" subtitle="Register a new household unit for Barangay Poblacion" icon="fa-solid fa-house-chimney-medical" maxWidth="3xl">
    <form method="POST" action="{{ route('households.store') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Household Number *</label>
                <input type="text" name="household_number" value="HH-{{ date('Y') }}-{{ rand(1000, 9999) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Head of Family Full Name *</label>
                <input type="text" name="head_name" placeholder="e.g., Juan Dela Cruz" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Purok / Zone *</label>
                <select name="purok" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                    <option value="Purok 1">Purok 1</option>
                    <option value="Purok 2">Purok 2</option>
                    <option value="Purok 3">Purok 3</option>
                    <option value="Purok 4">Purok 4</option>
                    <option value="Purok 5">Purok 5</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Street Address</label>
                <input type="text" name="address" placeholder="Brgy. Poblacion, New Lucena" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Sanitary Toilet Type</label>
                <select name="sanitary_toilet" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                    <option value="Water-sealed / Flush Toilet">Water-sealed / Flush Toilet</option>
                    <option value="Pit Latrine">Pit Latrine</option>
                    <option value="None / Shared">None / Shared</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Water Source Level</label>
                <select name="water_source" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                    <option value="Level III (Piped tap into household)">Level III (Piped tap into household)</option>
                    <option value="Level II (Communal faucet)">Level II (Communal faucet)</option>
                    <option value="Level I (Point source / Deep well)">Level I (Point source / Deep well)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 pt-2">
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">GPS Latitude (Optional)</label>
                <input type="number" step="any" name="latitude" value="10.8875" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono text-xs">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">GPS Longitude (Optional)</label>
                <input type="number" step="any" name="longitude" value="122.6108" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono text-xs">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'add-household-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs shadow-lg">Save Household</button>
        </div>
    </form>
</x-ui.modal>
@endsection
