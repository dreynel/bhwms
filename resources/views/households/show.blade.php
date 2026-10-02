@extends('layouts.app')

@section('title', 'Household ' . $household->household_number)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <span class="text-xs font-mono px-2.5 py-1 rounded bg-brand-500/20 text-brand-400 font-bold">{{ $household->household_number }}</span>
            <h1 class="font-heading text-2xl font-extrabold text-white mt-1">Head of Family: {{ $household->head_name }}</h1>
            <p class="text-xs text-slate-400 mt-0.5"><i class="fa-solid fa-location-dot text-brand-400 mr-1"></i> {{ $household->purok }}, {{ $household->barangay }}, {{ $household->municipality }}</p>
        </div>
        <div class="flex items-center space-x-2">
            <button @click="$dispatch('open-modal', 'add-resident-modal')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
                <i class="fa-solid fa-user-plus mr-1"></i>
                <span>Add Family Member</span>
            </button>
            <a href="{{ route('residents.create') }}?household_id={{ $household->id }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-emerald-100 dark:hover:bg-slate-700 transition" title="Full Page Form">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
            <a href="{{ route('households.edit', $household) }}" class="px-3 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition">Edit</a>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-1">
            <p class="text-slate-500 uppercase font-semibold text-[10px]">Sanitary Facilities</p>
            <p class="text-white font-bold text-sm">{{ $household->sanitary_toilet }}</p>
            <p class="text-slate-400">Water Source: <span class="text-slate-200 font-medium">{{ $household->water_source }}</span></p>
        </div>

        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-1">
            <p class="text-slate-500 uppercase font-semibold text-[10px]">Economic Category</p>
            <p class="text-white font-bold text-sm">{{ $household->income_bracket }}</p>
            <p class="text-slate-400">Address: <span class="text-slate-200 font-medium">{{ $household->address_details ?: 'N/A' }}</span></p>
        </div>

        <div class="bg-slate-900 p-4 rounded-2xl border border-slate-800 space-y-1">
            <p class="text-slate-500 uppercase font-semibold text-[10px]">Coordinates</p>
            @if($household->latitude && $household->longitude)
                <p class="text-emerald-400 font-mono font-bold text-sm">{{ number_format($household->latitude, 6) }}, {{ number_format($household->longitude, 6) }}</p>
                <p class="text-slate-400"><i class="fa-solid fa-check text-emerald-400 mr-1"></i> Verified on Barangay Map</p>
            @else
                <p class="text-slate-500 italic">No coordinates saved</p>
            @endif
        </div>
    </div>

    <!-- Family Members List -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 p-6 space-y-4">
        <h2 class="font-heading text-lg font-bold text-white flex items-center space-x-2">
            <i class="fa-solid fa-users text-brand-400"></i>
            <span>Family Members & Resident Health Profiles</span>
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950 uppercase text-[10px] tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Age / Sex</th>
                        <th class="py-3 px-4">PhilHealth #</th>
                        <th class="py-3 px-4">Vulnerabilities</th>
                        <th class="py-3 px-4">Contact</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($household->residents as $res)
                        <tr class="hover:bg-slate-800/40">
                            <td class="py-3 px-4 font-semibold text-white">
                                {{ $res->full_name }}
                                @if($res->is_head)
                                    <span class="ml-1 text-[10px] uppercase px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold">Head</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $res->age }} yrs / {{ $res->sex }}</td>
                            <td class="py-3 px-4 font-mono text-slate-400">{{ $res->philhealth_number ?: 'N/A' }}</td>
                            <td class="py-3 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($res->vulnerabilities as $v)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-rose-500/20 text-rose-300 border border-rose-500/30">{{ $v }}</span>
                                    @empty
                                        <span class="text-slate-500 italic">None</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="py-3 px-4 font-mono text-slate-400">{{ $res->contact_number ?: 'N/A' }}</td>
                            <td class="py-3 px-4 text-right">
                                <a href="{{ route('residents.show', $res) }}" class="text-brand-400 hover:underline font-semibold">View Profile &rarr;</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-slate-500 italic">No family members registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modular Add Member Modal for this Household -->
<x-ui.modal name="add-resident-modal" title="Add Resident to Household {{ $household->household_number }}" subtitle="Register family member into {{ $household->head_name }}'s household" icon="fa-solid fa-user-plus" maxWidth="3xl">
    <form method="POST" action="{{ route('residents.store') }}" class="space-y-4 text-xs">
        @csrf
        <input type="hidden" name="household_id" value="{{ $household->id }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">First Name *</label>
                <input type="text" name="first_name" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Middle Name</label>
                <input type="text" name="middle_name" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Last Name *</label>
                <input type="text" name="last_name" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Suffix (Jr, III, etc.)</label>
                <input type="text" name="suffix" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Date of Birth *</label>
                <input type="date" name="date_of_birth" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Sex *</label>
                <select name="sex" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Civil Status</label>
                <select name="civil_status" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500">
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">PhilHealth Number</label>
                <input type="text" name="philhealth_number" placeholder="12-digit PhilHealth ID" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono focus:outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Contact Phone</label>
                <input type="text" name="contact_number" placeholder="09xxxxxxxxx" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono focus:outline-none focus:border-emerald-500">
            </div>

            <div class="flex items-center space-x-2 pt-6">
                <input type="checkbox" name="is_head" id="is_head_cb" value="1" class="w-4 h-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <label for="is_head_cb" class="font-bold text-slate-800 dark:text-slate-200">Designate as Head of Household</label>
            </div>
        </div>

        <!-- Vulnerability Flags -->
        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2">
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300">Special Health Categories / Vulnerability Flags</label>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                <label class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="vulnerabilities[]" value="Pregnant" class="w-4 h-4 rounded text-pink-600 focus:ring-pink-500">
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Pregnant</span>
                </label>
                <label class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="vulnerabilities[]" value="Lactating" class="w-4 h-4 rounded text-pink-600 focus:ring-pink-500">
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Lactating</span>
                </label>
                <label class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="vulnerabilities[]" value="Senior Citizen" class="w-4 h-4 rounded text-amber-600 focus:ring-amber-500">
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Senior Citizen (60+)</span>
                </label>
                <label class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="vulnerabilities[]" value="PWD" class="w-4 h-4 rounded text-purple-600 focus:ring-purple-500">
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">PWD</span>
                </label>
                <label class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="vulnerabilities[]" value="Hypertensive" class="w-4 h-4 rounded text-rose-600 focus:ring-rose-500">
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Hypertensive</span>
                </label>
                <label class="flex items-center space-x-2 p-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 cursor-pointer">
                    <input type="checkbox" name="vulnerabilities[]" value="Diabetic" class="w-4 h-4 rounded text-rose-600 focus:ring-rose-500">
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Diabetic</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'add-resident-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Register Member</button>
        </div>
    </form>
</x-ui.modal>
@endsection
