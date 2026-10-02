@extends('layouts.app')

@section('title', 'Completed Visits Summary Report')

@section('content')
<div class="space-y-6">
    <!-- Action Header & Filters -->
    <div class="no-print bg-slate-900 p-4 rounded-2xl border border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-xl font-bold text-white">Completed Health Visits Summary Report</h1>
            <p class="text-xs text-slate-400">Filter by date or Purok and print official summary</p>
        </div>
        <div class="flex items-center space-x-2">
            <button onclick="window.print()" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs shadow-lg flex items-center space-x-2">
                <i class="fa-solid fa-print"></i>
                <span>Print Official Summary</span>
            </button>
            <a href="{{ route('reports.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold">Back</a>
        </div>
    </div>

    <!-- Official Printable Report Container -->
    <div class="card-box bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl space-y-6">
        <!-- Official Header (Visible on print & view) -->
        <div class="text-center border-b border-slate-800 pb-6 space-y-1">
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Republic of the Philippines &bull; Province of Iloilo</p>
            <h2 class="font-heading text-lg font-extrabold text-white uppercase">Municipality of New Lucena</h2>
            <h3 class="font-heading text-base font-bold text-emerald-400">BARANGAY POBLACION HEALTH STATION</h3>
            <p class="text-xs text-slate-300 font-medium">COMPLETED HEALTH VISITS SUMMARY REPORT</p>
            <p class="text-[11px] text-slate-500 font-mono">Date Generated: {{ date('F d, Y h:i A') }}</p>
        </div>

        <!-- Summary Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-700 uppercase text-[10px] text-slate-400">
                        <th class="py-2.5 px-3">Date/Time</th>
                        <th class="py-2.5 px-3">Resident Name</th>
                        <th class="py-2.5 px-3">Purok</th>
                        <th class="py-2.5 px-3">Assigned BHW</th>
                        <th class="py-2.5 px-3">Services Rendered</th>
                        <th class="py-2.5 px-3">Vitals</th>
                        <th class="py-2.5 px-3">GPS Location</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($logs as $log)
                        <tr>
                            <td class="py-3 px-3 font-mono font-semibold">{{ $log->captured_at ? $log->captured_at->format('M d, Y h:i A') : 'Recorded' }}</td>
                            <td class="py-3 px-3 font-bold">{{ $log->resident->full_name }}</td>
                            <td class="py-3 px-3">{{ $log->resident->household->purok ?? 'N/A' }}</td>
                            <td class="py-3 px-3">{{ $log->bhw->name }}</td>
                            <td class="py-3 px-3">{{ $log->services_rendered }}</td>
                            <td class="py-3 px-3 font-mono text-[11px]">{{ $log->vitals_bp ?: 'N/A' }}</td>
                            <td class="py-3 px-3 font-mono text-[11px]">
                                {{ number_format($log->latitude, 4) }}, {{ number_format($log->longitude, 4) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 italic text-slate-500">No completed visit records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Official Signatures -->
        <div class="pt-8 border-t border-slate-800 grid grid-cols-2 gap-8 text-xs">
            <div>
                <p class="text-slate-400">Prepared by:</p>
                <div class="mt-8 border-b border-slate-700 w-48"></div>
                <p class="font-bold text-white mt-1">Barangay Health Worker</p>
            </div>
            <div class="text-right">
                <p class="text-slate-400">Approved & Noted by:</p>
                <div class="mt-8 border-b border-slate-700 w-48 ml-auto"></div>
                <p class="font-bold text-white mt-1">{{ $setting->captain_name ?? 'Hon. Jose R. Maravilla' }}</p>
                <p class="text-slate-400 text-[11px]">Punong Barangay</p>
            </div>
        </div>
    </div>
</div>
@endsection
