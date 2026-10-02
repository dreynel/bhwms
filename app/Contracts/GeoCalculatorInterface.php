<?php

namespace App\Contracts;

use App\ValueObjects\GeoCoordinates;

/**
 * Abstraction for Geolocation Algorithms (OOP Principle: Strategy Pattern)
 */
interface GeoCalculatorInterface
{
    public function calculateDistance(GeoCoordinates $pointA, GeoCoordinates $pointB): float;

    public function isWithinThreshold(GeoCoordinates $visitPoint, GeoCoordinates $householdPoint, float $maxDistanceMeters = 250.0): bool;
}
