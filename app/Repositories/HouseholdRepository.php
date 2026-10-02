<?php

namespace App\Repositories;

use App\Contracts\HouseholdRepositoryInterface;
use App\Models\Household;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Household Repository Implementation (OOP Principle: Single Responsibility & Encapsulation)
 */
class HouseholdRepository implements HouseholdRepositoryInterface
{
    public function getFilteredPaginated(?string $search, ?string $purok, int $perPage = 15): LengthAwarePaginator
    {
        $query = Household::withCount('residents');

        if ($purok) {
            $query->where('purok', $purok);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('household_number', 'like', "%{$search}%")
                  ->orWhere('head_name', 'like', "%{$search}%")
                  ->orWhere('address_details', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('household_number', 'asc')->paginate($perPage);
    }

    public function getAllHouseholds(): Collection
    {
        return Household::orderBy('household_number')->get();
    }

    public function findById(int $id): ?Household
    {
        return Household::with('residents.visitLogs', 'creator')->find($id);
    }

    public function create(array $data): Household
    {
        return Household::create($data);
    }

    public function update(Household $household, array $data): bool
    {
        return $household->update($data);
    }

    public function delete(Household $household): bool
    {
        return $household->delete();
    }
}
