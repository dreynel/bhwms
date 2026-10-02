@extends('layouts.app')

@section('title', 'Schedule Visit')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Schedule Health Visit</h1>
            <p class="text-xs text-slate-400 mt-1">Set visit date, service type & field instructions</p>
        </div>
        <a href="{{ route('visits.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Schedules</a>
    </div>

    <form method="POST" action="{{ route('visits.store') }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf

        <div class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Select Target Resident *</label>
                <select name="resident_id" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                    <option value="">-- Choose Resident --</option>
                    @foreach($residents as $r)
                        <option value="{{ $r->id }}" {{ request('resident_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->full_name }} ({{ $r->household->purok ?? 'Brgy' }}) - {{ $r->contact_number ?: 'No Contact' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Assigned BHW Personnel *</label>
                <select name="bhw_user_id" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                    <option value="">-- Select BHW --</option>
                    @foreach($bhws as $b)
                        <option value="{{ $b->id }}" {{ Auth::id() == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->purok }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold uppercase text-slate-400 mb-1">Scheduled Date *</label>
                    <input type="date" name="scheduled_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                </div>

                <div>
                    <label class="block font-semibold uppercase text-slate-400 mb-1">Scheduled Time</label>
                    <input type="time" name="scheduled_time" value="09:00" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold uppercase text-slate-400 mb-1">Service / Visit Type *</label>
                    <select name="visit_type" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                        <option value="maternal_checkup">Maternal / Prenatal Checkup</option>
                        <option value="child_immunization">Child Immunization / Weigh-in</option>
                        <option value="senior_wellness">Senior Citizen Wellness</option>
                        <option value="tb_followup">TB / Communicable Follow-up</option>
                        <option value="routine_monitoring">Routine Household Monitoring</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold uppercase text-slate-400 mb-1">Priority Level *</label>
                    <select name="priority" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500">
                        <option value="medium">Medium Priority</option>
                        <option value="high">High Priority</option>
                        <option value="urgent">Urgent</option>
                        <option value="low">Low Priority</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Visit Objectives & Instructions</label>
                <textarea name="notes" rows="3" placeholder="Notes for the BHW or details regarding the visit..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-brand-500"></textarea>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800 text-xs">
            <a href="{{ route('visits.index') }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg">Save Visit Schedule</button>
        </div>
    </form>
</div>
@endsection
