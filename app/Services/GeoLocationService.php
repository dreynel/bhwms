<?php

namespace App\Services;

use App\Contracts\GeoCalculatorInterface;
use App\ValueObjects\GeoCoordinates;

/**
 * Service implementing Haversine Geolocation Algorithm (OOP Principle: Strategy Pattern & Polymorphism)
 */
class GeoLocationService implements GeoCalculatorInterface
{
    /**
     * Calculate distance between two GeoCoordinates in meters
     */
    public function calculateDistance(GeoCoordinates $pointA, GeoCoordinates $pointB): float
    {
        $earthRadius = 6371000; // Earth radius in meters

        $dLat = deg2rad($pointB->getLatitude() - $pointA->getLatitude());
        $dLon = deg2rad($pointB->getLongitude() - $pointA->getLongitude());

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($pointA->getLatitude())) * cos(deg2rad($pointB->getLatitude())) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    /**
     * Check if visit point is within distance threshold of household
     */
    public function isWithinThreshold(GeoCoordinates $visitPoint, GeoCoordinates $householdPoint, float $maxDistanceMeters = 250.0): bool
    {
        $distance = $this->calculateDistance($visitPoint, $householdPoint);
        return $distance <= $maxDistanceMeters;
    }

    /**
     * Primitive type compatibility method
     */
    public function isWithinThresholdRaw(float $visitLat, float $visitLon, float $houseLat, float $houseLon, float $maxDistanceMeters = 250.0): bool
    {
        return $this->isWithinThreshold(
            new GeoCoordinates($visitLat, $visitLon),
            new GeoCoordinates($houseLat, $houseLon),
            $maxDistanceMeters
        );
    }
}
