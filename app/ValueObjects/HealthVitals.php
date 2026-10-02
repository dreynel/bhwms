<?php

namespace App\ValueObjects;

/**
 * Immutable Value Object for Patient Vitals (OOP Principle: Encapsulation)
 */
final class HealthVitals
{
    private ?string $bp;
    private ?float $weightKg;
    private ?float $temperatureC;
    private ?string $bloodSugar;

    public function __construct(?string $bp = null, ?float $weightKg = null, ?float $temperatureC = null, ?string $bloodSugar = null)
    {
        $this->bp = $bp;
        $this->weightKg = $weightKg;
        $this->temperatureC = $temperatureC;
        $this->bloodSugar = $bloodSugar;
    }

    public function getBp(): ?string
    {
        return $this->bp;
    }

    public function getWeightKg(): ?float
    {
        return $this->weightKg;
    }

    public function getTemperatureC(): ?float
    {
        return $this->temperatureC;
    }

    public function getBloodSugar(): ?string
    {
        return $this->bloodSugar;
    }

    public function isNormalBp(): bool
    {
        if (!$this->bp) return true;
        $parts = explode('/', $this->bp);
        if (count($parts) === 2) {
            $sys = (int)$parts[0];
            $dia = (int)$parts[1];
            return $sys < 130 && $dia < 85;
        }
        return true;
    }
}
