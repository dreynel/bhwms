<?php

namespace App\Contracts;

use App\Models\Household;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Household Repository Contract (OOP Principle: Repository Pattern & Interface Segregation)
 */
interface HouseholdRepositoryInterface
{
    public function getFilteredPaginated(?string $search, ?string $purok, int $perPage = 15): LengthAwarePaginator;

    public function getAllHouseholds(): Collection;

    public function findById(int $id): ?Household;

    public function create(array $data): Household;

    public function update(Household $household, array $data): bool;

    public function delete(Household $household): bool;
}
