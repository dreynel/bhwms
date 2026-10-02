<?php

namespace App\ValueObjects;

/**
 * Value Object encapsulating ISO/IEC 25010 metric calculations (OOP Principle: Domain Encapsulation)
 */
final class IsoEvaluationResult
{
    private array $scores;
    private float $mean;
    private string $interpretation;

    public function __construct(array $scores)
    {
        $this->scores = array_values($scores);
        $this->mean = count($this->scores) > 0 ? round(array_sum($this->scores) / count($this->scores), 2) : 0.0;
        $this->interpretation = $this->calculateInterpretation($this->mean);
    }

    public function getMean(): float
    {
        return $this->mean;
    }

    public function getInterpretation(): string
    {
        return $this->interpretation;
    }

    private function calculateInterpretation(float $mean): string
    {
        if ($mean >= 4.50) return 'Excellent (Very High Quality)';
        if ($mean >= 3.50) return 'Very Satisfactory (High Quality)';
        if ($mean >= 2.50) return 'Satisfactory (Moderate Quality)';
        if ($mean >= 1.50) return 'Fair (Needs Improvement)';
        return 'Poor (Unacceptable Quality)';
    }
}
