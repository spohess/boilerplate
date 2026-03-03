<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\Order\Actions\PlaceOrderAction;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Supports\Exceptions\ValidatorException;
use Illuminate\Http\JsonResponse;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        private PlaceOrderAction $action,
    ) {}

    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        try {
            $order = $this->action->execute($request->validated());

            return new OrderResource($order)->response()->setStatusCode(201);
        } catch (ValidatorException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 422);
        } catch (Throwable $t) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
