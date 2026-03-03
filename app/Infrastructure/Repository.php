<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Supports\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use InvalidArgumentException;
use RuntimeException;

abstract class Repository implements RepositoryInterface
{
    public function __construct(protected Model $model) {}

    abstract protected function applyFilter(
        Builder $query,
        array $filter,
    ): Builder;

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function collect(array $filter): Collection
    {
        $query = $this->applyFilter($this->model->query(), $filter);

        return $query->get();
    }

    public function find(array $filter): ?Model
    {
        $query = $this->applyFilter($this->model->query(), $filter);

        return $query->first();
    }

    public function findOrFail(array $filter): Model
    {
        $query = $this->applyFilter($this->model->query(), $filter);

        return $query->firstOrFail();
    }

    public function exists(array $filter): bool
    {
        $query = $this->applyFilter($this->model->query(), $filter);

        return $query->exists();
    }

    public function count(array $filter): int
    {
        $query = $this->applyFilter($this->model->query(), $filter);

        return $query->count();
    }

    public function paginate(array $filter, int $perPage = 15, int $page = 1): LengthAwarePaginator
    {
        $query = $this->applyFilter($this->model->query(), $filter);

        return $query->paginate(perPage: $perPage, page: $page);
    }

    public function update(array $data, array $filter): bool
    {
        $query = $this->buildSafeQuery($filter);

        return (bool) $query->update($data);
    }

    public function updateById(int $id, array $data): bool
    {
        return (bool) $this->model->query()->where(
            $this->model->getKeyName(),
            $id,
        )->update($data);
    }

    public function delete(array $filter): bool
    {
        $query = $this->buildSafeQuery($filter);

        return (bool) $query->delete();
    }

    public function deleteById(int $id): bool
    {
        return (bool) $this->model->query()->where(
            $this->model->getKeyName(),
            $id,
        )->delete();
    }

    protected function buildSafeQuery(array $filter): Builder
    {
        if (empty($filter)) {
            throw new InvalidArgumentException('Required filter for write operations');
        }

        $query = $this->applyFilter($this->model->query(), $filter);

        if ($query->toRawSql() === $this->model->query()->toRawSql()) {
            throw new RuntimeException('No filter was applied to the query');
        }

        return $query;
    }
}
