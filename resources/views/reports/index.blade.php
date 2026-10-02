@extends('layouts.app')

@section('title', 'Printable & Searchable Summaries')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="font-heading text-2xl font-extrabold text-white">Searchable & Printable Summaries</h1>
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-amber-500/20 text-amber-400 border border-amber-500/30">Objective 5 Verified</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Generate official DOH & LGU health summaries for Barangay Poblacion, New Lucena, Iloilo</p>
        </div>
    </div>

    <!-- Reports Hub Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Completed Visits Summary Report Card -->
        <div class="glass-card p-6 rounded-3xl space-y-4 hover:border-emerald-500/40 transition">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 text-2xl">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <h2 class="font-heading text-lg font-bold text-slate-900 dark:text-white">Completed Visits & Activity Summary</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Printable summary of field health visits completed by BHW workers, filtered by date range and Purok.</p>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <button @click="$dispatch('open-modal', 'filter-completed-visits-modal')" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs transition shadow-md shadow-emerald-700/20">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filter & Print</span>
                </button>
                <a href="{{ route('reports.completed-visits') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition">
                    <i class="fa-solid fa-print"></i>
                    <span>All Records</span>
                </a>
            </div>
        </div>

        <!-- Pending Follow-ups Checklist Report Card -->
        <div class="glass-card p-6 rounded-3xl space-y-4 hover:border-amber-500/40 transition">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-600 dark:text-amber-400 text-2xl">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <div>
                <h2 class="font-heading text-lg font-bold text-slate-900 dark:text-white">Pending Follow-ups Checklist</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Searchable roster of residents requiring follow-up health visits, prenatal checkups, or immunizations.</p>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <button @click="$dispatch('open-modal', 'filter-pending-followups-modal')" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs transition shadow-md shadow-amber-700/20">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filter by Purok</span>
                </button>
                <a href="{{ route('reports.pending-followups') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition">
                    <i class="fa-solid fa-print"></i>
                    <span>All Puroks</span>
                </a>
            </div>
        </div>

        <!-- Worker Activities Report Card -->
        <div class="glass-card p-6 rounded-3xl space-y-4 hover:border-teal-500/40 transition">
            <div class="w-12 h-12 rounded-2xl bg-teal-500/10 flex items-center justify-center text-teal-600 dark:text-teal-400 text-2xl">
                <i class="fa-solid fa-user-nurse"></i>
            </div>
            <div>
                <h2 class="font-heading text-lg font-bold text-slate-900 dark:text-white">BHW Worker Performance & Activities</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Monthly performance summary of assigned BHW workers, visits conducted, and area coverage.</p>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <button @click="$dispatch('open-modal', 'filter-worker-activities-modal')" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs transition shadow-md shadow-teal-700/20">
                    <i class="fa-solid fa-sliders"></i>
                    <span>Filter Month/BHW</span>
                </button>
                <a href="{{ route('reports.worker-activities') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition">
                    <i class="fa-solid fa-print"></i>
                    <span>Current Month</span>
                </a>
            </div>
        </div>

        <!-- Household Survey Report Card -->
        <div class="glass-card p-6 rounded-3xl space-y-4 hover:border-indigo-500/40 transition">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-2xl">
                <i class="fa-solid fa-house-chimney-medical"></i>
            </div>
            <div>
                <h2 class="font-heading text-lg font-bold text-slate-900 dark:text-white">Household Sanitation & Water Source Summary</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Official masterlist of surveyed households, sanitary toilet facilities, water sources, and income classifications.</p>
            </div>
            <div class="flex items-center space-x-2 pt-2">
                <a href="{{ route('forms.household-survey') }}" class="inline-flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition shadow-md shadow-indigo-700/20">
                    <i class="fa-solid fa-print"></i>
                    <span>View Survey Report</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1: Filter Completed Visits -->
<x-ui.modal name="filter-completed-visits-modal" title="Customize Completed Visits Report" subtitle="Filter by date range, purok, or assigned BHW" icon="fa-solid fa-filter" maxWidth="lg">
    <form method="GET" action="{{ route('reports.completed-visits') }}" class="space-y-4 text-xs">
        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Start Date</label>
            <input type="date" name="start_date" value="{{ date('Y-m-01') }}" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">End Date</label>
            <input type="date" name="end_date" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Purok Area</label>
            <select name="purok" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                <option value="">All Puroks (1 to 7)</option>
                <option value="Purok 1">Purok 1</option>
                <option value="Purok 2">Purok 2</option>
                <option value="Purok 3">Purok 3</option>
                <option value="Purok 4">Purok 4</option>
                <option value="Purok 5">Purok 5</option>
            </select>
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">BHW Personnel</label>
            <select name="bhw_id" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                <option value="">All BHW Personnel</option>
                @foreach($bhws as $b)
                    <option value="{{ $b->id }}">{{ $b->name }} ({{ $b->purok ?? 'BHS' }})</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'filter-completed-visits-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Generate Report</button>
        </div>
    </form>
</x-ui.modal>

<!-- Modal 2: Filter Pending Follow-ups -->
<x-ui.modal name="filter-pending-followups-modal" title="Filter Follow-ups Checklist" subtitle="Select purok zone for targeted follow-up roster" icon="fa-solid fa-clipboard-list" maxWidth="md">
    <form method="GET" action="{{ route('reports.pending-followups') }}" class="space-y-4 text-xs">
        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Purok Area</label>
            <select name="purok" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-amber-500">
                <option value="">All Puroks (1 to 7)</option>
                <option value="Purok 1">Purok 1</option>
                <option value="Purok 2">Purok 2</option>
                <option value="Purok 3">Purok 3</option>
                <option value="Purok 4">Purok 4</option>
                <option value="Purok 5">Purok 5</option>
            </select>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'filter-pending-followups-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-bold shadow-lg">Generate Checklist</button>
        </div>
    </form>
</x-ui.modal>

<!-- Modal 3: Filter Worker Activities -->
<x-ui.modal name="filter-worker-activities-modal" title="Filter BHW Performance Report" subtitle="Select target month and evaluation period" icon="fa-solid fa-user-nurse" maxWidth="md">
    <form method="GET" action="{{ route('reports.worker-activities') }}" class="space-y-4 text-xs">
        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Evaluation Month</label>
            <input type="month" name="month_year" value="{{ date('Y-m') }}" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-teal-500">
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'filter-worker-activities-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold shadow-lg">Generate Performance</button>
        </div>
    </form>
</x-ui.modal>
@endsection
