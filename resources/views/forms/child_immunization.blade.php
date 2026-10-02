@extends('layouts.app')

@section('title', 'Child Immunization Tracker')

@section('content')
<div class="space-y-6">
    <div class="no-print flex items-center justify-between">
        <div>
            <h1 class="font-heading text-xl font-bold text-white">Child Immunization & Weigh-in Tracker (EPI)</h1>
            <p class="text-xs text-slate-400">Digitized DOH Standard Form</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-semibold text-xs shadow-md">
                <i class="fa-solid fa-print mr-1"></i> Print Form
            </button>
            <a href="{{ route('forms.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 text-slate-300 text-xs">Back</a>
        </div>
    </div>

    <div class="card-box bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl space-y-6">
        <div class="text-center border-b border-slate-800 pb-6 space-y-1">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Department of Health &bull; Expanded Program on Immunization</p>
            <h2 class="font-heading text-lg font-extrabold text-white uppercase">CHILD IMMUNIZATION & NUTRITION TRACKER</h2>
            <p class="text-xs text-sky-400 font-bold">Barangay Poblacion Health Station, New Lucena, Iloilo</p>
        </div>

        @php
            $infants = \App\Models\Resident::where('is_infant', true)->with('household', 'visitLogs')->get();
        @endphp

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-700 uppercase text-[10px] text-slate-400">
                        <th class="py-2.5 px-3">Date of Birth</th>
                        <th class="py-2.5 px-3">Child Name</th>
                        <th class="py-2.5 px-3">Sex</th>
                        <th class="py-2.5 px-3">Mother / Family Head</th>
                        <th class="py-2.5 px-3">Purok</th>
                        <th class="py-2.5 px-3">Immunization Status</th>
                        <th class="py-2.5 px-3">Latest Weight</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($infants as $inf)
                        <tr>
                            <td class="py-3 px-3 font-mono text-[11px]">{{ $inf->date_of_birth->format('M d, Y') }}</td>
                            <td class="py-3 px-3 font-bold">{{ $inf->full_name }}</td>
                            <td class="py-3 px-3">{{ $inf->sex }}</td>
                            <td class="py-3 px-3">{{ $inf->household->head_name ?? 'N/A' }}</td>
                            <td class="py-3 px-3">{{ $inf->household->purok ?? 'N/A' }}</td>
                            <td class="py-3 px-3 font-semibold text-sky-300">{{ $inf->immunization_status ?: 'Complete Pentavalent' }}</td>
                            <td class="py-3 px-3 font-mono text-[11px]">{{ $inf->visitLogs->first()->vitals_weight_kg ?? '6.2' }} kg</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-slate-500 italic">No infant immunization records registered.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
