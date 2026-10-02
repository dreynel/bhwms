@extends('layouts.app')

@section('title', 'Digitized Forms & System Setup')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="font-heading text-2xl font-extrabold text-slate-900 dark:text-white">Digitized Forms & Barangay Configuration</h1>
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-500/20 text-indigo-700 dark:text-indigo-300 border border-indigo-500/30">Objective 1 Verified</span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">DOH approved health forms repository and LGU Barangay header configuration</p>
        </div>
        <button @click="$dispatch('open-modal', 'edit-settings-modal')" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md shadow-emerald-700/20 flex items-center space-x-2 transition">
            <i class="fa-solid fa-sliders"></i>
            <span>Configure Barangay Station</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Digitized Standard Forms Repository -->
        <div class="lg:col-span-2 space-y-4">
            <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-file-signature text-indigo-400"></i>
                <span>Approved Department of Health (DOH) Digitized Forms</span>
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <!-- Form 1 -->
                <div class="p-5 bg-slate-900 rounded-3xl border border-slate-800 space-y-3 shadow-lg">
                    <div class="w-10 h-10 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-400 text-lg">
                        <i class="fa-solid fa-person-pregnant"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm">Target Client List for Maternal Care</h3>
                        <p class="text-slate-400 text-[11px] mt-1">DOH TCL form tracking pregnant mothers, prenatal visits, iron supplements, and tetanus toxoid immunization.</p>
                    </div>
                    <a href="{{ route('forms.target-client-maternal') }}" class="inline-block px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs">View Digitized Form &rarr;</a>
                </div>

                <!-- Form 2 -->
                <div class="p-5 bg-slate-900 rounded-3xl border border-slate-800 space-y-3 shadow-lg">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/10 flex items-center justify-center text-sky-400 text-lg">
                        <i class="fa-solid fa-baby"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm">Child Immunization Tracker (EPI)</h3>
                        <p class="text-slate-400 text-[11px] mt-1">Expanded Program on Immunization form tracking BCG, Pentavalent, OPV, and Measles vaccines.</p>
                    </div>
                    <a href="{{ route('forms.child-immunization') }}" class="inline-block px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs">View Digitized Form &rarr;</a>
                </div>

                <!-- Form 3 -->
                <div class="p-5 bg-slate-900 rounded-3xl border border-slate-800 space-y-3 shadow-lg sm:col-span-2">
                    <div class="w-10 h-10 rounded-xl bg-brand-500/10 flex items-center justify-center text-brand-400 text-lg">
                        <i class="fa-solid fa-clipboard-user"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm">Barangay Household Health Survey Profile</h3>
                        <p class="text-slate-400 text-[11px] mt-1">Standardized survey form assessing family demographics, sanitary toilet facilities, water sources, and income brackets.</p>
                    </div>
                    <a href="{{ route('forms.household-survey') }}" class="inline-block px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs">View Survey Form &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Barangay Settings Configuration -->
        <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4 text-xs">
            <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-sliders text-brand-400"></i>
                <span>Barangay Information Setup</span>
            </h2>

            <form method="POST" action="{{ route('forms.update-settings') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Barangay Name</label>
                    <input type="text" name="barangay_name" value="{{ old('barangay_name', $setting->barangay_name) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Municipality</label>
                        <input type="text" name="municipality" value="{{ old('municipality', $setting->municipality) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                    </div>
                    <div>
                        <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Province</label>
                        <input type="text" name="province" value="{{ old('province', $setting->province) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Punong Barangay (Captain)</label>
                    <input type="text" name="captain_name" value="{{ old('captain_name', $setting->captain_name) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>

                <div>
                    <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Municipal Health Officer</label>
                    <input type="text" name="health_officer_name" value="{{ old('health_officer_name', $setting->health_officer_name) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>

                <div>
                    <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Health Station Contact Phone</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>

                <div>
                    <label class="block text-slate-400 mb-1 font-semibold uppercase text-[10px]">Health Station Address</label>
                    <input type="text" name="office_address" value="{{ old('office_address', $setting->office_address) }}" required class="w-full px-3 py-2 bg-slate-950 border border-slate-800 rounded-xl text-white">
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold rounded-xl shadow-md transition">
                    Save Barangay Settings
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modular Edit Barangay Settings Modal -->
<x-ui.modal name="edit-settings-modal" title="Barangay Health Station Configuration" subtitle="Update official names, health officer, and contact info" icon="fa-solid fa-sliders" maxWidth="2xl">
    <form method="POST" action="{{ route('forms.update-settings') }}" class="space-y-4 text-xs">
        @csrf
        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Barangay Name *</label>
            <input type="text" name="barangay_name" value="{{ old('barangay_name', $setting->barangay_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 font-semibold">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Municipality *</label>
                <input type="text" name="municipality" value="{{ old('municipality', $setting->municipality) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 font-semibold">
            </div>
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Province *</label>
                <input type="text" name="province" value="{{ old('province', $setting->province) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 font-semibold">
            </div>
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Punong Barangay (Captain) *</label>
            <input type="text" name="captain_name" value="{{ old('captain_name', $setting->captain_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 font-semibold">
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Municipal Health Officer *</label>
            <input type="text" name="health_officer_name" value="{{ old('health_officer_name', $setting->health_officer_name) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 font-semibold">
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Health Station Contact Phone *</label>
            <input type="text" name="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-mono focus:outline-none focus:border-emerald-500">
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Health Station Office Address *</label>
            <input type="text" name="office_address" value="{{ old('office_address', $setting->office_address) }}" required class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-emerald-500 font-semibold">
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'edit-settings-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold shadow-lg">Save Settings</button>
        </div>
    </form>
</x-ui.modal>
@endsection
