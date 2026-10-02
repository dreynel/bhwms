@extends('layouts.app')

@section('title', 'BHW Purok Assignments')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900 dark:text-white">Barangay Health Worker Assignments</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Assign BHW Personnel to specific Puroks & Monitor Area Coverage</p>
        </div>
        <div>
            <button @click="$dispatch('open-modal', 'add-assignment-modal')" class="px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg flex items-center space-x-2 transition">
                <i class="fa-solid fa-user-shield"></i>
                <span>Assign BHW to Purok</span>
            </button>
        </div>
    </div>

    <!-- Active Assignments Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h3 class="font-heading text-sm font-bold text-slate-900 dark:text-white">Current Active Coverage Roster</h3>
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">{{ count($assignments) }} Assigned BHW(s)</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-950 uppercase text-[10px] tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">BHW Name</th>
                        <th class="py-3.5 px-4">Assigned Area</th>
                        <th class="py-3.5 px-4">Contact #</th>
                        <th class="py-3.5 px-4">Assignment Date</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                    @forelse($assignments as $assign)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">{{ $assign->user->name ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4"><span class="px-2.5 py-1 rounded bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 font-bold">{{ $assign->purok }}</span></td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 dark:text-slate-400">{{ $assign->user->phone_number ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-slate-500 dark:text-slate-400">{{ $assign->assigned_date ? $assign->assigned_date->format('M d, Y') : 'N/A' }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-emerald-500/20 text-emerald-700 dark:text-emerald-400">Active</span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <form method="POST" action="{{ route('assignments.destroy', $assign) }}" data-confirm="Remove {{ $assign->user->name ?? 'worker' }} from {{ $assign->purok }}?" data-confirm-title="Revoke BHW Assignment" data-confirm-button="Yes, Revoke" data-confirm-icon="warning">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 dark:text-rose-400 hover:underline font-semibold text-xs">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-500 italic">No BHW assignments recorded.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modular Quick Assign BHW Modal Component -->
<x-ui.modal name="add-assignment-modal" title="Assign BHW Worker to Purok" subtitle="Assign area coverage to Barangay Health Worker" icon="fa-solid fa-user-shield" maxWidth="xl">
    <form method="POST" action="{{ route('assignments.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Select BHW Personnel *</label>
            <select name="user_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                <option value="">-- Choose BHW Worker --</option>
                @foreach($bhws as $b)
                    <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->purok }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Assigned Purok *</label>
            <select name="purok" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                @foreach($puroks as $p)
                    <option value="{{ $p }}">{{ $p }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Assignment Date *</label>
            <input type="date" name="assigned_date" value="{{ date('Y-m-d') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'add-assignment-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs shadow-lg">Confirm Assignment</button>
        </div>
    </form>
</x-ui.modal>
@endsection
