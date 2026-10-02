<?php

namespace App\Contracts;

use App\Models\Resident;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Resident Repository Contract (OOP Principle: Repository Pattern)
 */
interface ResidentRepositoryInterface
{
    public function getFilteredPaginated(?string $search, ?string $vulnerability, ?string $purok, int $perPage = 15): LengthAwarePaginator;

    public function getAllResidents(): Collection;

    public function findById(int $id): ?Resident;

    public function create(array $data): Resident;

    public function update(Resident $resident, array $data): bool;

    public function delete(Resident $resident): bool;
}
