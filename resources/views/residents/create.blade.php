@extends('layouts.app')

@section('title', 'Add New Resident')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Add Resident Health Profile</h1>
            <p class="text-xs text-slate-400 mt-1">Register resident demographic & vulnerability flags</p>
        </div>
        <a href="{{ route('residents.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Registry</a>
    </div>

    <form method="POST" action="{{ route('residents.store') }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Select Household *</label>
                <select name="household_id" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="">-- Choose Household --</option>
                    @foreach($households as $hh)
                        <option value="{{ $hh->id }}" {{ request('household_id') == $hh->id ? 'selected' : '' }}>
                            {{ $hh->household_number }} - {{ $hh->head_name }} ({{ $hh->purok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Suffix (Jr, III, etc.)</label>
                <input type="text" name="suffix" value="{{ old('suffix') }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Date of Birth *</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Sex *</label>
                <select name="sex" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Civil Status</label>
                <select name="civil_status" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Contact Number / Mobile</label>
                <input type="text" name="contact_number" value="{{ old('contact_number') }}" placeholder="0917XXXXXXX" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">PhilHealth Number</label>
                <input type="text" name="philhealth_number" value="{{ old('philhealth_number') }}" placeholder="12-345678901-2" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-brand-500">
            </div>
        </div>

        <!-- Vulnerability Flags -->
        <div class="border-t border-slate-800 pt-4 space-y-3">
            <h3 class="text-xs font-bold uppercase text-brand-400"><i class="fa-solid fa-notes-medical mr-1"></i> Vulnerability & Health Profile Indicators</h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_head" value="1" class="rounded bg-slate-900 border-slate-700 text-brand-500">
                    <span class="text-slate-200">Head of Family</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_pregnant" value="1" class="rounded bg-slate-900 border-slate-700 text-pink-500">
                    <span class="text-slate-200">Pregnant / Maternal</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_lactating" value="1" class="rounded bg-slate-900 border-slate-700 text-pink-400">
                    <span class="text-slate-200">Lactating Mother</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_infant" value="1" class="rounded bg-slate-900 border-slate-700 text-sky-400">
                    <span class="text-slate-200">Infant / Child</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_senior" value="1" class="rounded bg-slate-900 border-slate-700 text-amber-400">
                    <span class="text-slate-200">Senior Citizen (60+)</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_pwd" value="1" class="rounded bg-slate-900 border-slate-700 text-purple-400">
                    <span class="text-slate-200">PWD</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="has_hypertension" value="1" class="rounded bg-slate-900 border-slate-700 text-rose-400">
                    <span class="text-slate-200">Hypertension</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="has_diabetes" value="1" class="rounded bg-slate-900 border-slate-700 text-rose-500">
                    <span class="text-slate-200">Diabetes</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Medical & Health Notes</label>
            <textarea name="medical_notes" rows="2" placeholder="Maintenance medication, immunization history, or special health conditions..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
            <a href="{{ route('residents.index') }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white font-semibold text-xs rounded-xl shadow-lg">Save Resident Profile</button>
        </div>
    </form>
</div>
@endsection
