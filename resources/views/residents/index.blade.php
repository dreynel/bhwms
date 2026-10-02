@extends('layouts.app')

@section('title', 'Residents Profile Registry')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-slate-900 dark:text-white">Barangay Resident Records</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Barangay Poblacion, Municipality of New Lucena &bull; Health & Demographics Registry</p>
        </div>
        <div class="flex items-center space-x-2">
            <button @click="$dispatch('open-modal', 'add-resident-modal')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-user-plus"></i>
                <span>Add Resident</span>
            </button>
            <a href="{{ route('residents.create') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-emerald-100 dark:hover:bg-slate-700 transition" title="Full Page Registration">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-md">
        <form method="GET" action="{{ route('residents.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or PhilHealth #..." class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-brand-500">
            </div>
            <div>
                <select name="vulnerability" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="">All Health Categories</option>
                    <option value="pregnant" {{ request('vulnerability') == 'pregnant' ? 'selected' : '' }}>Pregnant / Maternal</option>
                    <option value="lactating" {{ request('vulnerability') == 'lactating' ? 'selected' : '' }}>Lactating Mother</option>
                    <option value="infant" {{ request('vulnerability') == 'infant' ? 'selected' : '' }}>Infant (0-12m)</option>
                    <option value="senior" {{ request('vulnerability') == 'senior' ? 'selected' : '' }}>Senior Citizen (60+)</option>
                    <option value="pwd" {{ request('vulnerability') == 'pwd' ? 'selected' : '' }}>PWD</option>
                    <option value="hypertension" {{ request('vulnerability') == 'hypertension' ? 'selected' : '' }}>Hypertension</option>
                    <option value="diabetes" {{ request('vulnerability') == 'diabetes' ? 'selected' : '' }}>Diabetes</option>
                </select>
            </div>
            <div>
                <select name="purok" class="w-full px-3.5 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="">All Puroks</option>
                    <option value="Purok 1" {{ request('purok') == 'Purok 1' ? 'selected' : '' }}>Purok 1</option>
                    <option value="Purok 2" {{ request('purok') == 'Purok 2' ? 'selected' : '' }}>Purok 2</option>
                    <option value="Purok 3" {{ request('purok') == 'Purok 3' ? 'selected' : '' }}>Purok 3</option>
                    <option value="Purok 4" {{ request('purok') == 'Purok 4' ? 'selected' : '' }}>Purok 4</option>
                    <option value="Purok 5" {{ request('purok') == 'Purok 5' ? 'selected' : '' }}>Purok 5</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                <button type="submit" class="w-full py-2 bg-slate-800 dark:bg-slate-800 hover:bg-slate-700 text-white font-semibold text-xs rounded-xl transition">
                    <i class="fa-solid fa-filter mr-1"></i> Search
                </button>
                @if(request()->anyFilled(['search', 'vulnerability', 'purok']))
                    <a href="{{ route('residents.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-950 text-slate-600 dark:text-slate-400 hover:text-white text-xs rounded-xl border border-slate-200 dark:border-slate-800"><i class="fa-solid fa-rotate-left"></i></a>
                @endif
            </div>
        </form>
    </div>

    <!-- Residents Data Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-950 uppercase text-[10px] tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Resident Name</th>
                        <th class="py-3.5 px-4">Household #</th>
                        <th class="py-3.5 px-4">Purok</th>
                        <th class="py-3.5 px-4">Age / Sex</th>
                        <th class="py-3.5 px-4">PhilHealth #</th>
                        <th class="py-3.5 px-4">Vulnerability Flags</th>
                        <th class="py-3.5 px-4">Contact</th>
                        <th class="py-3.5 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60">
                    @forelse($residents as $res)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4 font-semibold text-slate-900 dark:text-white">
                                {{ $res->full_name }}
                                @if($res->is_head)
                                    <span class="ml-1 text-[10px] uppercase px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-700 dark:text-amber-300 font-bold">Head</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-slate-600 dark:text-slate-300">{{ $res->household->household_number ?? 'N/A' }}</td>
                            <td class="py-3.5 px-4"><span class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-teal-700 dark:text-teal-300 font-semibold text-[11px]">{{ $res->household->purok ?? 'N/A' }}</span></td>
                            <td class="py-3.5 px-4">{{ $res->age }} yrs / {{ $res->sex }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-500 dark:text-slate-400">{{ $res->philhealth_number ?: 'N/A' }}</td>
                            <td class="py-3.5 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($res->vulnerabilities as $v)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-rose-500/10 dark:bg-rose-500/20 text-rose-700 dark:text-rose-300 border border-rose-500/30">{{ $v }}</span>
                                    @empty
                                        <span class="text-slate-400 dark:text-slate-500 italic">None</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-700 dark:text-slate-300">{{ $res->contact_number ?: 'N/A' }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('residents.show', $res) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">Details &rarr;</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-8 text-slate-500 italic">No resident records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            {{ $residents->links() }}
        </div>
    </div>
</div>

<!-- Modular Add Resident Modal Component -->
<x-ui.modal name="add-resident-modal" title="Quick Register New Resident" subtitle="Add resident profile to Barangay Masterlist" icon="fa-solid fa-user-plus" maxWidth="3xl">
    <form method="POST" action="{{ route('residents.store') }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Select Household *</label>
                <select name="household_id" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                    <option value="">-- Choose Household --</option>
                    @foreach($households as $hh)
                        <option value="{{ $hh->id }}">
                            {{ $hh->household_number }} - {{ $hh->head_name }} ({{ $hh->purok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">First Name *</label>
                <input type="text" name="first_name" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Middle Name</label>
                <input type="text" name="middle_name" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Last Name *</label>
                <input type="text" name="last_name" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Date of Birth *</label>
                <input type="date" name="date_of_birth" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Sex *</label>
                <select name="sex" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs focus:outline-none focus:border-blue-500">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-400 mb-1">Contact Number / Mobile</label>
                <input type="text" name="contact_number" placeholder="0917XXXXXXX" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-blue-500">
            </div>
        </div>

        <!-- Health Vulnerability Checklist -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <h4 class="text-xs font-extrabold uppercase text-blue-600 dark:text-amber-400">Vulnerability Flags</h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                <label class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-950 p-2 rounded-xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_head" value="1" class="rounded text-blue-600">
                    <span class="text-slate-700 dark:text-slate-300">Head of Family</span>
                </label>
                <label class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-950 p-2 rounded-xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_pregnant" value="1" class="rounded text-pink-500">
                    <span class="text-slate-700 dark:text-slate-300">Pregnant</span>
                </label>
                <label class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-950 p-2 rounded-xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_senior" value="1" class="rounded text-amber-500">
                    <span class="text-slate-700 dark:text-slate-300">Senior Citizen</span>
                </label>
                <label class="flex items-center space-x-2 bg-slate-100 dark:bg-slate-950 p-2 rounded-xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_pwd" value="1" class="rounded text-purple-500">
                    <span class="text-slate-700 dark:text-slate-300">PWD</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'add-resident-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs shadow-lg">Save Resident Profile</button>
        </div>
    </form>
</x-ui.modal>
@endsection
