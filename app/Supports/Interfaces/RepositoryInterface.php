<?php

declare(strict_types=1);

namespace App\Supports\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function create(array $data): Model;

    public function update(array $data, array $filter): bool;

    public function updateById(int $id, array $data): bool;

    public function delete(array $filter): bool;

    public function deleteById(int $id): bool;

    public function find(array $filter): ?Model;

    public function findOrFail(array $filter): Model;

    public function collect(array $filter): Collection;

    public function exists(array $filter): bool;

    public function count(array $filter): int;

    public function paginate(array $filter, int $perPage = 15, int $page = 1): LengthAwarePaginator;
}
