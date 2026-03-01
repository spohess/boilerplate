<?php

declare(strict_types=1);

namespace App\Domains\Order\Repositories\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterById
{
    public function __construct(private readonly array $filters) {}

    public function handle(Builder $query, Closure $next): Builder
    {
        if (isset($this->filters['id'])) {
            $query->where('id', $this->filters['id']);
        }

        return $next($query);
    }
}
