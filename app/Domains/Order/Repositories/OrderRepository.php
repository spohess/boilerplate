<?php

declare(strict_types=1);

namespace App\Domains\Order\Repositories;

use App\Domains\Order\Repositories\Filters\FilterByCustomerEmail;
use App\Domains\Order\Repositories\Filters\FilterByProduct;
use App\Domains\Order\Repositories\Filters\FilterByStatus;
use App\Models\Order;
use App\Supports\Abstracts\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

class OrderRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(new Order());
    }

    protected function applyFilter(Builder $query, array $filter): Builder
    {
        return Pipeline::send($query)
            ->pipe(new FilterByStatus($filter))
            ->pipe(new FilterByCustomerEmail($filter))
            ->pipe(new FilterByProduct($filter))
            ->thenReturn();
    }
}
