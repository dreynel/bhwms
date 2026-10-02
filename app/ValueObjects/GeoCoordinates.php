<?php

namespace App\ValueObjects;

/**
 * Immutable Value Object representing Geolocation Coordinates (OOP Principle: Encapsulation & Immutability)
 */
final class GeoCoordinates
{
    private float $latitude;
    private float $longitude;
    private float $accuracyMeters;

    public function __construct(float $latitude, float $longitude, float $accuracyMeters = 0.0)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->accuracyMeters = $accuracyMeters;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAccuracyMeters(): float
    {
        return $this->accuracyMeters;
    }

    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'accuracy_meters' => $this->accuracyMeters,
        ];
    }

    public function __toString(): string
    {
        return sprintf("%.6f, %.6f (±%.1fm)", $this->latitude, $this->longitude, $this->accuracyMeters);
    }
}
