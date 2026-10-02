@extends('layouts.app')

@section('title', 'ISO/IEC 25010:2011 Quality Evaluation')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2">
                <h1 class="font-heading text-2xl font-extrabold text-white">ISO/IEC 25010:2011 Quality Evaluation Engine</h1>
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-purple-500/20 text-purple-300 border border-purple-500/30">Objective 6 Verified</span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Product-Quality Evaluation across 8 ISO/IEC 25010 characteristics based on user ratings & expert review</p>
        </div>
        <div class="flex items-center space-x-2 self-start md:self-auto">
            <button @click="$dispatch('open-modal', 'submit-evaluation-modal')" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs shadow-lg flex items-center space-x-2 transition">
                <i class="fa-solid fa-pen-to-square"></i>
                <span>Submit ISO Quality Evaluation</span>
            </button>
            <a href="{{ route('iso-evaluation.create') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-purple-100 dark:hover:bg-slate-700 transition" title="Full Page Form">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
        </div>
    </div>

    <!-- Overall Mean Score & Verbal Interpretation Banner -->
    <div class="bg-gradient-to-r from-purple-950 via-slate-900 to-slate-900 p-6 rounded-3xl border border-purple-900/50 shadow-2xl flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-2">
            <span class="text-xs font-bold uppercase tracking-wider text-purple-400"><i class="fa-solid fa-award mr-1"></i> System Quality Benchmark</span>
            <div class="flex items-baseline space-x-3">
                <span class="font-heading text-4xl sm:text-5xl font-extrabold text-white">{{ number_format($overallMean, 2) }}</span>
                <span class="text-slate-400 text-sm font-semibold">/ 5.00 Overall Mean</span>
            </div>
            <p class="text-base font-bold text-emerald-400 flex items-center space-x-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>Verbal Interpretation: {{ $verbalInterpretation }}</span>
            </p>
        </div>

        <div class="text-right text-xs text-slate-400 space-y-1">
            <p>Total Evaluator Reviews: <strong class="text-white font-bold text-sm">{{ $totalEvaluations }}</strong></p>
            <p>Evaluation Standard: <strong class="text-purple-300">ISO/IEC 25010:2011 Software Quality Model</strong></p>
            <p>Likert Scale: <span class="text-slate-300">1 (Poor) to 5 (Excellent)</span></p>
        </div>
    </div>

    <!-- 8 ISO Characteristics Mean Cards Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 text-xs">
        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Functional</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgFunctional, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Performance</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgPerformance, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Compatibility</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgCompatibility, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Usability</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgUsability, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Reliability</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgReliability, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Security</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgSecurity, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Maintainability</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgMaintainability, 2) }}</p>
        </div>

        <div class="bg-slate-900 p-3.5 rounded-2xl border border-slate-800 text-center space-y-1">
            <p class="text-[10px] uppercase font-bold text-slate-400 truncate">Portability</p>
            <p class="font-heading text-xl font-extrabold text-emerald-400">{{ number_format($avgPortability, 2) }}</p>
        </div>
    </div>

    <!-- Visual Radar Chart & Characteristics Description Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Radar Chart Container -->
        <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-chart-radar text-purple-400"></i>
                <span>ISO/IEC 25010 Quality Model Radar Breakdown</span>
            </h2>
            <div class="w-full h-72 flex items-center justify-center">
                <canvas id="isoRadarChart"></canvas>
            </div>
        </div>

        <!-- 8 Product Characteristics Overview -->
        <div class="bg-slate-900 p-6 rounded-3xl border border-slate-800 shadow-xl space-y-4">
            <h2 class="font-heading text-base font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-layer-group text-brand-400"></i>
                <span>Evaluated Characteristics & Sub-metrics</span>
            </h2>

            <div class="space-y-2 text-xs text-slate-300 overflow-y-auto max-h-72 pr-2">
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">1. Functional Suitability (Score: {{ $avgFunctional }})</p>
                    <p class="text-slate-400 text-[11px]">Completeness of household profiling, visit scheduling, vital signs tracking, and location capture.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">2. Performance Efficiency (Score: {{ $avgPerformance }})</p>
                    <p class="text-slate-400 text-[11px]">Response speed of search queries, map rendering, and database transaction times.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">3. Compatibility (Score: {{ $avgCompatibility }})</p>
                    <p class="text-slate-400 text-[11px]">Co-existence with mobile web browsers, OpenStreetMap tiles, and responsive mobile interfaces.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">4. Usability (Score: {{ $avgUsability }})</p>
                    <p class="text-slate-400 text-[11px]">User interface clarity, learnability for BHW workers, and error protection.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">5. Reliability (Score: {{ $avgReliability }})</p>
                    <p class="text-slate-400 text-[11px]">System availability, data consistency, and fault tolerance during field GPS capture.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">6. Security (Score: {{ $avgSecurity }})</p>
                    <p class="text-slate-400 text-[11px]">Role-based access control (RBAC), password hashing, and restricted map authorization.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">7. Maintainability (Score: {{ $avgMaintainability }})</p>
                    <p class="text-slate-400 text-[11px]">Clean Laravel MVC architecture, database migrations, and modular services.</p>
                </div>
                <div class="p-2.5 bg-slate-950 rounded-xl border border-slate-800">
                    <p class="font-bold text-white">8. Portability (Score: {{ $avgPortability }})</p>
                    <p class="text-slate-400 text-[11px]">Cross-platform compatibility across smartphones, tablets, and desktop web browsers.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluator Reviews Table -->
    <div class="bg-slate-900 rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-4 border-b border-slate-800">
            <h3 class="font-heading text-sm font-bold text-white">Submitted Evaluator Reviews & Qualitative Feedback</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950 uppercase text-[10px] tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Evaluator Name</th>
                        <th class="py-3.5 px-4">Role / Group</th>
                        <th class="py-3.5 px-4">Organization</th>
                        <th class="py-3.5 px-4">Overall Mean</th>
                        <th class="py-3.5 px-4">Verbal Interpretation</th>
                        <th class="py-3.5 px-4">Qualitative Feedback</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($evaluations as $e)
                        <tr class="hover:bg-slate-800/40">
                            <td class="py-3.5 px-4 font-bold text-white">{{ $e->evaluator_name }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-800 text-purple-300">{{ strtoupper($e->evaluator_role) }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400">{{ $e->organization }}</td>
                            <td class="py-3.5 px-4 font-mono font-bold text-emerald-400 text-sm">{{ number_format($e->overall_mean, 2) }}</td>
                            <td class="py-3.5 px-4 font-semibold text-emerald-300">{{ $e->verbal_interpretation }}</td>
                            <td class="py-3.5 px-4 text-slate-300 max-w-xs truncate">{{ $e->feedback_comments ?: 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-slate-500 italic">No ISO evaluations submitted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modular Submit ISO 25010 Quality Rating Modal -->
<x-ui.modal name="submit-evaluation-modal" title="Submit ISO/IEC 25010 Quality Evaluation" subtitle="Rate across 8 software product quality characteristics (Likert 1 to 5)" icon="fa-solid fa-award" maxWidth="3xl">
    <form method="POST" action="{{ route('iso-evaluation.store') }}" class="space-y-4 text-xs">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Evaluator Full Name *</label>
                <input type="text" name="evaluator_name" value="{{ Auth::user()->name }}" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-medium focus:outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Evaluator Category *</label>
                <select name="evaluator_role" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-medium focus:outline-none focus:border-purple-500">
                    <option value="bhw">Barangay Health Worker (End-User)</option>
                    <option value="supervisor">Health Supervisor / Officer</option>
                    <option value="it_expert">IT / Technical Domain Expert</option>
                    <option value="resident">Resident User</option>
                </select>
            </div>

            <div>
                <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Organization / Station *</label>
                <input type="text" name="organization" value="Barangay Health Station, New Lucena" required class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white font-medium focus:outline-none focus:border-purple-500">
            </div>
        </div>

        <div class="border-t border-slate-200 dark:border-slate-800 pt-3 space-y-2.5">
            <p class="font-bold uppercase text-purple-700 dark:text-purple-400 text-xs">8 Quality Characteristics (1 = Poor, 5 = Excellent)</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">1. Functional Suitability</p>
                        <p class="text-[10px] text-slate-500">Features completeness</p>
                    </div>
                    <select name="score_functional_suitability" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">2. Performance Efficiency</p>
                        <p class="text-[10px] text-slate-500">Speed and responsiveness</p>
                    </div>
                    <select name="score_performance_efficiency" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">3. Compatibility</p>
                        <p class="text-[10px] text-slate-500">Cross-device & browser</p>
                    </div>
                    <select name="score_compatibility" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">4. Usability</p>
                        <p class="text-[10px] text-slate-500">Ease of learning & UI</p>
                    </div>
                    <select name="score_usability" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">5. Reliability</p>
                        <p class="text-[10px] text-slate-500">Data accuracy & stability</p>
                    </div>
                    <select name="score_reliability" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">6. Security</p>
                        <p class="text-[10px] text-slate-500">RBAC & confidentiality</p>
                    </div>
                    <select name="score_security" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">7. Maintainability</p>
                        <p class="text-[10px] text-slate-500">Code structure & modularity</p>
                    </div>
                    <select name="score_maintainability" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>

                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white">8. Portability</p>
                        <p class="text-[10px] text-slate-500">Easy deploy & install</p>
                    </div>
                    <select name="score_portability" required class="px-2 py-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg text-purple-700 dark:text-purple-300 font-bold">
                        <option value="5">5 - Excellent</option>
                        <option value="4">4 - Very Good</option>
                        <option value="3">3 - Satisfactory</option>
                        <option value="2">2 - Fair</option>
                        <option value="1">1 - Poor</option>
                    </select>
                </div>
            </div>
        </div>

        <div>
            <label class="block font-bold uppercase text-slate-700 dark:text-slate-300 mb-1">Qualitative Feedback & Comments</label>
            <textarea name="feedback_comments" rows="2" placeholder="Evaluator feedback or recommendations..." class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:border-purple-500"></textarea>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-200 dark:border-slate-800">
            <button type="button" @click="$dispatch('close-modal', 'submit-evaluation-modal')" class="px-4 py-2 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-300 dark:hover:bg-slate-700">Cancel</button>
            <button type="submit" class="px-5 py-2 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold shadow-lg">Submit Evaluation</button>
        </div>
    </form>
</x-ui.modal>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('isoRadarChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [
                'Functional Suitability',
                'Performance Efficiency',
                'Compatibility',
                'Usability',
                'Reliability',
                'Security',
                'Maintainability',
                'Portability'
            ],
            datasets: [{
                label: 'System ISO 25010 Mean Ratings',
                data: [
                    {{ $avgFunctional }},
                    {{ $avgPerformance }},
                    {{ $avgCompatibility }},
                    {{ $avgUsability }},
                    {{ $avgReliability }},
                    {{ $avgSecurity }},
                    {{ $avgMaintainability }},
                    {{ $avgPortability }}
                ],
                backgroundColor: 'rgba(168, 85, 247, 0.25)',
                borderColor: '#c084fc',
                pointBackgroundColor: '#e9d5ff',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#c084fc'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    angleLines: { color: 'rgba(255, 255, 255, 0.1)' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    pointLabels: { color: '#cbd5e1', font: { size: 10 } },
                    suggestedMin: 1,
                    suggestedMax: 5,
                    ticks: { stepSize: 1, color: '#94a3b8', backdropColor: 'transparent' }
                }
            },
            plugins: {
                legend: { labels: { color: '#f8fafc', font: { family: 'Inter' } } }
            }
        }
    });
});
</script>
@endpush
@endsection
