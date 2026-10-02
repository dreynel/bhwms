@extends('layouts.app')

@section('title', 'Submit ISO/IEC 25010 Quality Evaluation')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-heading text-2xl font-extrabold text-white">ISO/IEC 25010:2011 Quality Rating Form</h1>
            <p class="text-xs text-slate-400 mt-1">Rate the system across 8 product quality characteristics (Likert 1 - 5)</p>
        </div>
        <a href="{{ route('iso-evaluation.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Back to Dashboard</a>
    </div>

    <form method="POST" action="{{ route('iso-evaluation.store') }}" class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-6">
        @csrf

        <!-- Evaluator Info -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Evaluator Full Name *</label>
                <input type="text" name="evaluator_name" value="{{ Auth::user()->name }}" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Evaluator Category *</label>
                <select name="evaluator_role" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-purple-500">
                    <option value="bhw">Barangay Health Worker (BHW End-User)</option>
                    <option value="supervisor">Health Supervisor / Officer</option>
                    <option value="it_expert">IT / Technical Domain Expert</option>
                    <option value="resident">Resident User</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold uppercase text-slate-400 mb-1">Organization / Station *</label>
                <input type="text" name="organization" value="Barangay Health Station, New Lucena" required class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white focus:outline-none focus:border-purple-500">
            </div>
        </div>

        <!-- Rating Grid -->
        <div class="border-t border-slate-800 pt-4 space-y-4 text-xs">
            <h3 class="font-bold uppercase text-purple-400"><i class="fa-solid fa-list-ol mr-1"></i> ISO/IEC 25010 Characteristics Rating (1 = Poor, 5 = Excellent)</h3>

            <div class="space-y-4">
                <!-- 1. Functional Suitability -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">1. Functional Suitability</span>
                            <p class="text-slate-400 text-[11px]">Does the system cover household profiling, visit scheduling, GPS capture, and printable reports completely?</p>
                        </div>
                        <select name="score_functional_suitability" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 2. Performance Efficiency -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">2. Performance Efficiency</span>
                            <p class="text-slate-400 text-[11px]">How fast and efficient are the page load times, map rendering, and database queries?</p>
                        </div>
                        <select name="score_performance_efficiency" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 3. Compatibility -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">3. Compatibility</span>
                            <p class="text-slate-400 text-[11px]">Does the web app integrate smoothly across browsers, mobile devices, and Leaflet maps?</p>
                        </div>
                        <select name="score_compatibility" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 4. Usability -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">4. Usability</span>
                            <p class="text-slate-400 text-[11px]">Is the user interface easy to understand, aesthetic, and user-error protected?</p>
                        </div>
                        <select name="score_usability" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 5. Reliability -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">5. Reliability</span>
                            <p class="text-slate-400 text-[11px]">How reliable is the system in preserving visit records and geolocation check-in data?</p>
                        </div>
                        <select name="score_reliability" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 6. Security -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">6. Security</span>
                            <p class="text-slate-400 text-[11px]">Is access properly restricted to authorized personnel via secure authentication and RBAC?</p>
                        </div>
                        <select name="score_security" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 7. Maintainability -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">7. Maintainability</span>
                            <p class="text-slate-400 text-[11px]">Is the codebase modular, well-structured, and easily modifiable for future barangay needs?</p>
                        </div>
                        <select name="score_maintainability" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>

                <!-- 8. Portability -->
                <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="font-bold text-white text-sm">8. Portability</span>
                            <p class="text-slate-400 text-[11px]">Does the system adapt seamlessly across mobile phones, tablets, and computers?</p>
                        </div>
                        <select name="score_portability" required class="px-3 py-1.5 bg-slate-900 border border-slate-700 rounded-xl text-purple-300 font-bold">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Very Satisfactory</option>
                            <option value="3">3 - Satisfactory</option>
                            <option value="2">2 - Fair</option>
                            <option value="1">1 - Poor</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-400 mb-1">Qualitative Feedback & Comments</label>
            <textarea name="feedback_comments" rows="3" placeholder="Additional observations, recommendations, or evaluation feedback..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-800 rounded-xl text-white text-xs focus:outline-none focus:border-purple-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-800 text-xs">
            <a href="{{ route('iso-evaluation.index') }}" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-xl font-semibold hover:bg-slate-700">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-purple-600 hover:bg-purple-500 text-white font-semibold rounded-xl shadow-lg">Calculate & Submit ISO Scores</button>
        </div>
    </form>
</div>
@endsection
