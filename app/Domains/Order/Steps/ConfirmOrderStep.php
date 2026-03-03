<?php

declare(strict_types=1);

namespace App\Domains\Order\Steps;

use App\Domains\Order\Repositories\OrderRepository;
use App\Events\OrderConfirmedEvent;
use App\Models\Order;
use App\Supports\Saga\SagaContext;
use App\Supports\Saga\SagaStepInterface;
use App\Supports\Saga\StepEventInterface;

final class ConfirmOrderStep implements SagaStepInterface, StepEventInterface
{
    public function __construct(private OrderRepository $orderRepository) {}

    public function run(SagaContext $context): void
    {
        /** @var Order $order */
        $order = $context->get('order');

        $this->orderRepository->updateById($order->id, ['status' => 'confirmed']);
    }

    public function rollback(SagaContext $context): void
    {
        /** @var Order $order */
        $order = $context->get('order');

        $this->orderRepository->updateById($order->id, ['status' => 'failed']);
    }

    public function event(SagaContext $context): object
    {
        return new OrderConfirmedEvent($context);
    }
}
