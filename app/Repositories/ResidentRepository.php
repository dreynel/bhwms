<?php

namespace App\Repositories;

use App\Contracts\ResidentRepositoryInterface;
use App\Models\Resident;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Resident Repository Implementation (OOP Principle: Repository Pattern)
 */
class ResidentRepository implements ResidentRepositoryInterface
{
    public function getFilteredPaginated(?string $search, ?string $vulnerability, ?string $purok, int $perPage = 15): LengthAwarePaginator
    {
        $query = Resident::with('household');

        if ($vulnerability) {
            if ($vulnerability === 'pregnant') $query->where('is_pregnant', true);
            elseif ($vulnerability === 'lactating') $query->where('is_lactating', true);
            elseif ($vulnerability === 'infant') $query->where('is_infant', true);
            elseif ($vulnerability === 'senior') $query->where('is_senior', true);
            elseif ($vulnerability === 'pwd') $query->where('is_pwd', true);
            elseif ($vulnerability === 'hypertension') $query->where('has_hypertension', true);
            elseif ($vulnerability === 'diabetes') $query->where('has_diabetes', true);
            elseif ($vulnerability === 'malnutrition') $query->where('has_malnutrition', true);
        }

        if ($purok) {
            $query->whereHas('household', function ($q) use ($purok) {
                $q->where('purok', $purok);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('philhealth_number', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('last_name', 'asc')->paginate($perPage);
    }

    public function getAllResidents(): Collection
    {
        return Resident::with('household')->orderBy('last_name')->get();
    }

    public function findById(int $id): ?Resident
    {
        return Resident::with('household', 'visitSchedules.bhw', 'visitLogs.bhw', 'notifications')->find($id);
    }

    public function create(array $data): Resident
    {
        return Resident::create($data);
    }

    public function update(Resident $resident, array $data): bool
    {
        return $resident->update($data);
    }

    public function delete(Resident $resident): bool
    {
        return $resident->delete();
    }
}
