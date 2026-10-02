@extends('layouts.app')

@section('title', 'Visit Schedules & Field Monitoring')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900 dark:text-white">Visit Schedules & Field Monitoring</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Manage routine patient follow-ups & BHW assigned field visits</p>
        </div>
        <div class="flex items-center space-x-2">
            <button @click="$dispatch('open-modal', 'schedule-visit-modal')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-calendar-plus"></i>
                <span>Schedule Health Visit</span>
            </button>
            <a href="{{ route('visits.create') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-emerald-100 dark:hover:bg-slate-700 transition" title="Full Page Form">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-md">
        <form method="GET" action="{{ route('visits.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
            <div>
                <select name="status" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div>
                <select name="visit_type" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    <option value="">All Service Types</option>
                    <option value="maternal_checkup" {{ request('visit_type') == 'maternal_checkup' ? 'selected' : '' }}>Maternal Prenatal</option>
                    <option value="child_immunization" {{ request('visit_type') == 'child_immunization' ? 'selected' : '' }}>Child Immunization</option>
                    <option value="senior_wellness" {{ request('visit_type') == 'senior_wellness' ? 'selected' : '' }}>Senior Wellness</option>
                    <option value="routine_monitoring" {{ request('visit_type') == 'routine_monitoring' ? 'selected' : '' }}>Routine Monitoring</option>
                </select>
            </div>

            <div>
                <select name="bhw_id" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    <option value="">All BHW Personnel</option>
                    @foreach($bhws as $b)
                        <option value="{{ $b->id }}" {{ request('bhw_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-slate-700 text-white font-semibold rounded-xl transition">
                    <i class="fa-solid fa-filter mr-1"></i> Filter
                </button>
                @if(request()->anyFilled(['status', 'visit_type', 'bhw_id']))
                    <a href="{{ route('visits.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-950 text-slate-600 dark:text-slate-400 hover:text-white rounded-xl border border-slate-200 dark:border-slate-800"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- Schedules Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-950 uppercase text-[10px] tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Scheduled Date</th>
                        <th class="py-3.5 px-4">Resident</th>
                        <th class="py-3.5 px-4">Purok</th>
                        <th class="py-3.5 px-4">Service Category</th>
                        <th class="py-3.5 px-4">Priority</th>
                        <th class="py-3.5 px-4">Assigned BHW</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                    @forelse($schedules as $sched)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                                <i class="fa-regular fa-calendar text-emerald-600 dark:text-emerald-400 mr-1"></i>
                                {{ $sched->scheduled_date->format('M d, Y') }}
                                @if($sched->scheduled_time)
                                    <span class="text-[10px] text-slate-500 font-mono block">{{ date('h:i A', strtotime($sched->scheduled_time)) }}</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                                <a href="{{ route('residents.show', $sched->resident) }}" class="hover:underline text-blue-600 dark:text-blue-400">{{ $sched->resident->full_name }}</a>
                                <span class="text-[10px] text-slate-500 block font-mono">{{ $sched->resident->contact_number ?: 'No Contact' }}</span>
                            </td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">{{ $sched->resident->household->purok ?? 'N/A' }}</span></td>
                            <td class="py-3.5 px-4 font-medium text-slate-800 dark:text-slate-200">{{ strtoupper(str_replace('_', ' ', $sched->visit_type)) }}</td>
                            <td class="py-3.5 px-4">
                                @if($sched->priority === 'urgent')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-500/20 text-rose-700 dark:text-rose-300 border border-rose-500/30">URGENT</span>
                                @elseif($sched->priority === 'high')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-700 dark:text-amber-300 border border-amber-500/30">HIGH</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">MEDIUM</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-800 dark:text-slate-200 font-medium">{{ $sched->bhw->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4">
                                @if($sched->status === 'completed')
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 uppercase"><i class="fa-solid fa-check mr-1"></i> Completed</span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/20 text-amber-700 dark:text-amber-300 uppercase"><i class="fa-solid fa-clock mr-1"></i> Scheduled</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5">
                                <!-- Log Visit GPS Button -->
                                @if($sched->status !== 'completed')
                                    <a href="{{ route('visit-logs.create') }}?schedule_id={{ $sched->id }}" title="Log Visit with Geolocation" class="px-2.5 py-1.5 inline-flex items-center space-x-1 rounded-lg bg-emerald-600/30 hover:bg-emerald-600 text-emerald-300 hover:text-white transition text-xs font-semibold">
                                        <i class="fa-solid fa-location-crosshairs"></i>
                                        <span>Log Check-in</span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-500 italic">No visit schedules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            {{ $schedules->links() }}
        </div>
    </div>
</div>

<!-- Modular Quick Schedule Health Visit Modal -->
<x-ui.modal name="schedule-visit-modal" title="Quick Schedule Health Visit" subtitle="Assign routine visit, immunization or wellness follow-up" icon="fa-solid fa-calendar-plus" maxWidth="3xl">
    <form method="POST" action="{{ route('visits.store') }}" class="space-y-4 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Target Resident *</label>
                <select name="resident_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="">-- Choose Resident --</option>
                    @foreach($residents as $r)
                        <option value="{{ $r->id }}">
                            {{ $r->full_name }} ({{ $r->household->purok ?? 'Brgy' }}) - {{ $r->contact_number ?: 'No Contact' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Assigned BHW Personnel *</label>
                <select name="bhw_user_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="">-- Select BHW --</option>
                    @foreach($bhws as $b)
                        <option value="{{ $b->id }}" {{ Auth::id() == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->purok ?? 'All Areas' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Scheduled Date *</label>
                <input type="date" name="scheduled_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Scheduled Time</label>
                <input type="time" name="scheduled_time" value="09:00" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Service / Visit Type *</label>
                <select name="visit_type" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="maternal_checkup">Maternal / Prenatal Checkup</option>
                    <option value="child_immunization">Child Immunization / Weigh-in</option>
                    <option value="senior_wellness">Senior Citizen Wellness</option>
                    <option value="tb_followup">TB / Communicable Follow-up</option>
                    <option value="routine_monitoring">Routine Household Monitoring</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Priority Level *</label>
                <select name="priority" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="medium">Medium Priority</option>
                    <option value="high">High Priority</option>
                    <option value="urgent">Urgent</option>
                    <option value="low">Low Priority</option>
                </select>
            </div>

            <div class="sm:col-span-2">
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Visit Objectives & Instructions</label>
                <textarea name="notes" rows="2" placeholder="Instructions for the BHW or notes regarding this patient..." class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500"></textarea>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'schedule-visit-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Save Visit Schedule</button>
        </div>
    </form>
</x-ui.modal>
@endsection
