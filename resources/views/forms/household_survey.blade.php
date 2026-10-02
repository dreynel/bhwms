@extends('layouts.app')

@section('title', 'Barangay Household Health Survey Form')

@section('content')
<div class="space-y-6">
    <div class="no-print flex items-center justify-between">
        <div>
            <h1 class="font-heading text-1xl font-bold text-white">Barangay Household Health Survey Master Form</h1>
            <p class="text-xs text-slate-400">Digitized Household Assessment Form</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-semibold text-xs shadow-md">
                <i class="fa-solid fa-print mr-1"></i> Print Master Survey
            </button>
            <a href="{{ route('forms.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs">Back</a>
        </div>
    </div>

    <div class="card-box bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl space-y-6">
        <div class="text-center border-b border-slate-800 pb-6 space-y-1">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Republic of the Philippines &bull; Municipality of New Lucena</p>
            <h2 class="font-heading text-lg font-extrabold text-white uppercase">BARANGAY POBLACION HOUSEHOLD HEALTH SURVEY SUMMARY</h2>
            <p class="text-xs text-emerald-400 font-bold">Barangay Health Workers Information Management System</p>
        </div>

        @php
            $households = \App\Models\Household::withCount('residents')->get();
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-700 uppercase text-[10px] text-slate-400">
                        <th class="py-2.5 px-3">HH #</th>
                        <th class="py-2.5 px-3">Head of Family</th>
                        <th class="py-2.5 px-3">Purok</th>
                        <th class="py-2.5 px-3">Members Count</th>
                        <th class="py-2.5 px-3">Sanitary Toilet</th>
                        <th class="py-2.5 px-3">Water Source</th>
                        <th class="py-2.5 px-3">Income Category</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($households as $hh)
                        <tr>
                            <td class="py-3 px-3 font-mono font-bold text-white">{{ $hh->household_number }}</td>
                            <td class="py-3 px-3 font-bold">{{ $hh->head_name }}</td>
                            <td class="py-3 px-3">{{ $hh->purok }}</td>
                            <td class="py-3 px-3 font-bold text-emerald-400">{{ $hh->residents_count }} members</td>
                            <td class="py-3 px-3">{{ $hh->sanitary_toilet }}</td>
                            <td class="py-3 px-3">{{ $hh->water_source }}</td>
                            <td class="py-3 px-3 font-semibold">{{ $hh->income_bracket }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-slate-500 italic">No household survey records available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
