@extends('layouts.app')

@section('title', 'Edit Resident ' . $resident->full_name)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">Edit Resident Health Profile</h1>
            <p class="text-xs text-slate-400 mt-1">{{ $resident->full_name }}</p>
        </div>
        <a href="{{ route('residents.show', $resident) }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Details</a>
    </div>

    <form method="POST" action="{{ route('residents.update', $resident) }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Select Household *</label>
                <select name="household_id" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    @foreach($households as $hh)
                        <option value="{{ $hh->id }}" {{ $resident->household_id == $hh->id ? 'selected' : '' }}>
                            {{ $hh->household_number }} - {{ $hh->head_name }} ({{ $hh->purok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">First Name *</label>
                <input type="text" name="first_name" value="{{ old('first_name', $resident->first_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Middle Name</label>
                <input type="text" name="middle_name" value="{{ old('middle_name', $resident->middle_name) }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Last Name *</label>
                <input type="text" name="last_name" value="{{ old('last_name', $resident->last_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Suffix</label>
                <input type="text" name="suffix" value="{{ old('suffix', $resident->suffix) }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Date of Birth *</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $resident->date_of_birth->format('Y-m-d')) }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Sex *</label>
                <select name="sex" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Male" {{ $resident->sex == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $resident->sex == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Civil Status</label>
                <select name="civil_status" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">
                    <option value="Single" {{ $resident->civil_status == 'Single' ? 'selected' : '' }}>Single</option>
                    <option value="Married" {{ $resident->civil_status == 'Married' ? 'selected' : '' }}>Married</option>
                    <option value="Widowed" {{ $resident->civil_status == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    <option value="Separated" {{ $resident->civil_status == 'Separated' ? 'selected' : '' }}>Separated</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $resident->contact_number) }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-brand-500">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">PhilHealth Number</label>
                <input type="text" name="philhealth_number" value="{{ old('philhealth_number', $resident->philhealth_number) }}" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs font-mono focus:outline-none focus:border-brand-500">
            </div>
        </div>

        <!-- Vulnerability Flags -->
        <div class="border-t border-slate-800 pt-4 space-y-3">
            <h3 class="text-xs font-bold uppercase text-brand-400">Vulnerability Flags</h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_head" value="1" {{ $resident->is_head ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-brand-500">
                    <span class="text-slate-200">Head of Family</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_pregnant" value="1" {{ $resident->is_pregnant ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-pink-500">
                    <span class="text-slate-200">Pregnant / Maternal</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_lactating" value="1" {{ $resident->is_lactating ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-pink-400">
                    <span class="text-slate-200">Lactating Mother</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_infant" value="1" {{ $resident->is_infant ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-sky-400">
                    <span class="text-slate-200">Infant / Child</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_senior" value="1" {{ $resident->is_senior ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-amber-400">
                    <span class="text-slate-200">Senior Citizen</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="is_pwd" value="1" {{ $resident->is_pwd ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-purple-400">
                    <span class="text-slate-200">PWD</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="has_hypertension" value="1" {{ $resident->has_hypertension ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-rose-400">
                    <span class="text-slate-200">Hypertension</span>
                </label>

                <label class="flex items-center space-x-2 bg-slate-950 p-2.5 rounded-xl border border-slate-800 cursor-pointer">
                    <input type="checkbox" name="has_diabetes" value="1" {{ $resident->has_diabetes ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-rose-500">
                    <span class="text-slate-200">Diabetes</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Medical Notes</label>
            <textarea name="medical_notes" rows="2" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-brand-500">{{ old('medical_notes', $resident->medical_notes) }}</textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800">
            <a href="{{ route('residents.show', $resident) }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl text-xs font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white font-semibold text-xs rounded-xl shadow-lg">Update Profile</button>
        </div>
    </form>
</div>
@endsection
