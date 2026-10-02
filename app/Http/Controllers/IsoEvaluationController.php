<?php

namespace App\Http\Controllers;

use App\Models\IsoEvaluation;
use Illuminate\Http\Request;

class IsoEvaluationController extends Controller
{
    public function index()
    {
        $evaluations = IsoEvaluation::orderBy('created_at', 'desc')->get();
        
        $totalEvaluations = $evaluations->count();
        
        // Calculate average per characteristic
        $avgFunctional = round($evaluations->avg('score_functional_suitability') ?? 0, 2);
        $avgPerformance = round($evaluations->avg('score_performance_efficiency') ?? 0, 2);
        $avgCompatibility = round($evaluations->avg('score_compatibility') ?? 0, 2);
        $avgUsability = round($evaluations->avg('score_usability') ?? 0, 2);
        $avgReliability = round($evaluations->avg('score_reliability') ?? 0, 2);
        $avgSecurity = round($evaluations->avg('score_security') ?? 0, 2);
        $avgMaintainability = round($evaluations->avg('score_maintainability') ?? 0, 2);
        $avgPortability = round($evaluations->avg('score_portability') ?? 0, 2);

        $overallMean = round($evaluations->avg('overall_mean') ?? 0, 2);
        $verbalInterpretation = IsoEvaluation::getInterpretation($overallMean);

        return view('iso_evaluation.index', compact(
            'evaluations', 'totalEvaluations',
            'avgFunctional', 'avgPerformance', 'avgCompatibility', 'avgUsability',
            'avgReliability', 'avgSecurity', 'avgMaintainability', 'avgPortability',
            'overallMean', 'verbalInterpretation'
        ));
    }

    public function create()
    {
        return view('iso_evaluation.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'evaluator_name' => 'required|string|max:255',
            'evaluator_role' => 'required|in:bhw,supervisor,it_expert,resident',
            'organization' => 'required|string|max:255',
            'score_functional_suitability' => 'required|numeric|min:1|max:5',
            'score_performance_efficiency' => 'required|numeric|min:1|max:5',
            'score_compatibility' => 'required|numeric|min:1|max:5',
            'score_usability' => 'required|numeric|min:1|max:5',
            'score_reliability' => 'required|numeric|min:1|max:5',
            'score_security' => 'required|numeric|min:1|max:5',
            'score_maintainability' => 'required|numeric|min:1|max:5',
            'score_portability' => 'required|numeric|min:1|max:5',
            'feedback_comments' => 'nullable|string',
        ]);

        $scores = [
            $validated['score_functional_suitability'],
            $validated['score_performance_efficiency'],
            $validated['score_compatibility'],
            $validated['score_usability'],
            $validated['score_reliability'],
            $validated['score_security'],
            $validated['score_maintainability'],
            $validated['score_portability'],
        ];

        $validated['overall_mean'] = IsoEvaluation::calculateMean($scores);
        $validated['verbal_interpretation'] = IsoEvaluation::getInterpretation($validated['overall_mean']);

        IsoEvaluation::create($validated);

        return redirect()->route('iso-evaluation.index')->with('success', 'ISO/IEC 25010:2011 Quality Evaluation submitted successfully! Overall Mean Score: ' . $validated['overall_mean']);
    }
}
