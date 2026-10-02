<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsoEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluator_name',
        'evaluator_role',
        'organization',
        'score_functional_suitability',
        'score_performance_efficiency',
        'score_compatibility',
        'score_usability',
        'score_reliability',
        'score_security',
        'score_maintainability',
        'score_portability',
        'overall_mean',
        'verbal_interpretation',
        'feedback_comments',
    ];

    public static function calculateMean(array $scores): float
    {
        return (new \App\ValueObjects\IsoEvaluationResult($scores))->getMean();
    }

    public static function getInterpretation(float $mean): string
    {
        return (new \App\ValueObjects\IsoEvaluationResult([$mean]))->getInterpretation();
    }
}
