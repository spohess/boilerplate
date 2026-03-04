<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::prefix('orders')
            ->name('orders.')
            ->group(__DIR__ . '/api/orders.php');
