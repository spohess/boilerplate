<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Order\Actions\PlaceOrderAction;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(
        private PlaceOrderAction $action,
    ) {}

    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->action->execute($request->validated());

        return response()->json($order, 201);
    }
}
