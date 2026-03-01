<?php

declare(strict_types=1);

namespace App\Domains\Order\Repositories\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByProduct
{
    public function __construct(private readonly array $filters) {}

    public function handle(Builder $query, Closure $next): Builder
    {
        if (isset($this->filters['product'])) {
            $query->where('product', $this->filters['product']);
        }

        return $next($query);
    }
}
