<?php

declare(strict_types=1);

namespace App\Domains\Order\Repositories\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class FilterByCustomerEmail
{
    public function __construct(private readonly array $filters) {}

    public function handle(Builder $query, Closure $next): Builder
    {
        if (isset($this->filters['customer_email'])) {
            $query->where('customer_email', $this->filters['customer_email']);
        }

        return $next($query);
    }
}
