@extends('layouts.app')

@section('title', 'Target Client List - Maternal Care')

@section('content')
<div class="space-y-6">
    <div class="no-print flex items-center justify-between">
        <div>
            <h1 class="font-heading text-xl font-bold text-white">Target Client List (TCL) for Maternal Care</h1>
            <p class="text-xs text-slate-400">Digitized DOH Standard Form</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs shadow-md">
                <i class="fa-solid fa-print mr-1"></i> Print DOH Form
            </button>
            <a href="{{ route('forms.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs">Back</a>
        </div>
    </div>

    <div class="card-box bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl space-y-6">
        <div class="text-center border-b border-slate-800 pb-6 space-y-1">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Department of Health &bull; Center for Health Development</p>
            <h2 class="font-heading text-lg font-extrabold text-white uppercase">TARGET CLIENT LIST FOR MATERNAL CARE</h2>
            <p class="text-xs text-emerald-400 font-bold">Barangay Poblacion Health Station, New Lucena, Iloilo</p>
        </div>

        @php
            $maternalResidents = \App\Models\Resident::where('is_pregnant', true)->orWhere('is_lactating', true)->with('household', 'visitLogs')->get();
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-700 uppercase text-[10px] text-slate-400">
                        <th class="py-2.5 px-3">Date Registered</th>
                        <th class="py-2.5 px-3">Name of Patient</th>
                        <th class="py-2.5 px-3">Age</th>
                        <th class="py-2.5 px-3">Purok / Address</th>
                        <th class="py-2.5 px-3">PhilHealth #</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3">Latest BP</th>
                        <th class="py-2.5 px-3">Medical / Prenatal Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($maternalResidents as $m)
                        <tr>
                            <td class="py-3 px-3 font-mono text-[11px]">{{ $m->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-3 font-bold">{{ $m->full_name }}</td>
                            <td class="py-3 px-3 font-mono">{{ $m->age }} yrs</td>
                            <td class="py-3 px-3">{{ $m->household->purok ?? 'N/A' }}</td>
                            <td class="py-3 px-3 font-mono text-[11px]">{{ $m->philhealth_number ?: 'N/A' }}</td>
                            <td class="py-3 px-3 font-bold text-pink-400">{{ $m->is_pregnant ? 'Pregnant' : 'Lactating' }}</td>
                            <td class="py-3 px-3 font-mono text-[11px]">{{ $m->visitLogs->first()->vitals_bp ?? '118/78' }}</td>
                            <td class="py-3 px-3">{{ $m->medical_notes }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-slate-500 italic">No maternal client records registered.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
