<?php

declare(strict_types=1);

use App\Infrastructure\Http\Orders\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('/', OrderController::class);
