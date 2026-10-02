@extends('layouts.app')

@section('title', 'Visit Activity Log #' . $visitLog->id)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Visit Activity Record #{{ $visitLog->id }}</h1>
            <p class="text-xs text-slate-400 mt-1">Logged on {{ $visitLog->captured_at ? $visitLog->captured_at->format('F d, Y h:i A') : 'Recorded' }}</p>
        </div>
        <a href="{{ route('visit-logs.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Logs</a>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6 text-xs">
        <!-- Resident & BHW Header -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-slate-800">
            <div>
                <p class="text-slate-500 uppercase font-semibold text-[10px]">Resident Profile</p>
                <p class="font-bold text-white text-base mt-0.5">{{ $visitLog->resident->full_name }}</p>
                <p class="text-slate-400">Household: {{ $visitLog->resident->household->household_number ?? 'N/A' }} ({{ $visitLog->resident->household->purok ?? 'Brgy' }})</p>
            </div>

            <div>
                <p class="text-slate-500 uppercase font-semibold text-[10px]">Assigned BHW Personnel</p>
                <p class="font-bold text-white text-base mt-0.5"><i class="fa-solid fa-user-nurse text-teal-400 mr-1"></i> {{ $visitLog->bhw->name }}</p>
                <p class="text-slate-400">Contact: {{ $visitLog->bhw->phone_number ?: 'N/A' }}</p>
            </div>
        </div>

        <!-- GPS Coordinates Card (Specific Objective 4) -->
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 space-y-2">
            <div class="flex items-center justify-between">
                <span class="font-bold text-emerald-300 uppercase text-[11px]"><i class="fa-solid fa-location-dot mr-1"></i> Saved Geolocation Coordinates & Accuracy</span>
                @if($visitLog->geo_verified)
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-300">Geo Verified</span>
                @endif
            </div>

            <div class="grid grid-cols-3 gap-2 font-mono text-slate-200">
                <div>
                    <span class="text-slate-500 text-[10px] block">LATITUDE</span>
                    <span class="font-bold text-emerald-400">{{ number_format($visitLog->latitude, 6) }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-[10px] block">LONGITUDE</span>
                    <span class="font-bold text-emerald-400">{{ number_format($visitLog->longitude, 6) }}</span>
                </div>
                <div>
                    <span class="text-slate-500 text-[10px] block">ACCURACY</span>
                    <span class="font-bold text-white">&plusmn;{{ $visitLog->accuracy_meters }} meters</span>
                </div>
            </div>
        </div>

        <!-- Health Findings & Vitals -->
        <div class="space-y-3">
            <h3 class="font-bold uppercase text-slate-400">Services & Health Assessment</h3>
            <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                <p class="text-slate-300"><strong>Services Rendered:</strong> {{ $visitLog->services_rendered }}</p>
                <p class="text-slate-400"><strong>Health Observations:</strong> {{ $visitLog->health_notes }}</p>

                @if($visitLog->vitals_bp || $visitLog->vitals_weight_kg)
                    <div class="pt-2 flex flex-wrap gap-4 text-slate-300 font-mono text-[11px] border-t border-slate-800">
                        @if($visitLog->vitals_bp) <span>Blood Pressure: <strong class="text-white">{{ $visitLog->vitals_bp }}</strong></span> @endif
                        @if($visitLog->vitals_weight_kg) <span>Weight: <strong class="text-white">{{ $visitLog->vitals_weight_kg }} kg</strong></span> @endif
                        @if($visitLog->vitals_temp_c) <span>Temperature: <strong class="text-white">{{ $visitLog->vitals_temp_c }} &deg;C</strong></span> @endif
                        @if($visitLog->vitals_blood_sugar) <span>Blood Sugar: <strong class="text-white">{{ $visitLog->vitals_blood_sugar }}</strong></span> @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Follow-up Status -->
        @if($visitLog->follow_up_needed)
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-300 space-y-1">
                <p class="font-bold"><i class="fa-solid fa-clock mr-1"></i> Follow-up Scheduled</p>
                <p>Target Date: <strong>{{ $visitLog->follow_up_date ? $visitLog->follow_up_date->format('F d, Y') : 'Pending Schedule' }}</strong></p>
                @if($visitLog->follow_up_reason)<p>Reason: {{ $visitLog->follow_up_reason }}</p>@endif
            </div>
        @endif
    </div>
</div>
@endsection
