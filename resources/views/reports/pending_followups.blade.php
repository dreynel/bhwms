@extends('layouts.app')

@section('title', 'Pending Follow-ups Checklist')

@section('content')
<div class="space-y-6">
    <div class="no-print bg-slate-900 p-4 rounded-2xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-xl font-bold text-white">Pending Follow-ups Checklist Report</h1>
            <p class="text-xs text-slate-400">Roster of residents requiring follow-up field visits</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-semibold text-xs shadow-lg flex items-center space-x-2">
                <i class="fa-solid fa-print"></i>
                <span>Print Checklist</span>
            </button>
            <a href="{{ route('reports.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold">Back</a>
        </div>
    </div>

    <div class="card-box bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl space-y-6">
        <div class="text-center border-b border-slate-800 pb-6 space-y-1">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Republic of the Philippines &bull; Province of Iloilo</p>
            <h2 class="font-heading text-lg font-extrabold text-white uppercase">Municipality of New Lucena</h2>
            <h3 class="font-heading text-base font-bold text-amber-400">BARANGAY POBLACION HEALTH STATION</h3>
            <p class="text-xs text-slate-300 font-medium">PENDING FOLLOW-UPS CHECKLIST REPORT</p>
            <p class="text-[11px] text-slate-500 font-mono">Date Generated: {{ date('F d, Y h:i A') }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-700 uppercase text-[10px] text-slate-400">
                        <th class="py-2.5 px-3">Follow-up Date</th>
                        <th class="py-2.5 px-3">Resident Name</th>
                        <th class="py-2.5 px-3">Purok</th>
                        <th class="py-2.5 px-3">Contact</th>
                        <th class="py-2.5 px-3">Assigned BHW</th>
                        <th class="py-2.5 px-3">Reason / Purpose</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($logs as $log)
                        <tr>
                            <td class="py-3 px-3 font-mono font-bold text-amber-400">{{ $log->follow_up_date ? $log->follow_up_date->format('M d, Y') : 'Pending' }}</td>
                            <td class="py-3 px-3 font-bold">{{ $log->resident->full_name }}</td>
                            <td class="py-3 px-3">{{ $log->resident->household->purok ?? 'N/A' }}</td>
                            <td class="py-3 px-3 font-mono">{{ $log->resident->contact_number ?: 'N/A' }}</td>
                            <td class="py-3 px-3">{{ $log->bhw->name }}</td>
                            <td class="py-3 px-3">{{ $log->follow_up_reason ?: 'Health Follow-up' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 italic text-slate-500">No pending follow-ups required at this time.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
