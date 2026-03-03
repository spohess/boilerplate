<?php

declare(strict_types=1);

use App\Infrastructure\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/orders', OrderController::class);
