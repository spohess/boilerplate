<?php

declare(strict_types=1);

namespace App\Domains\Order\Steps;

use App\Domains\Order\Models\Order;
use App\Domains\Order\Repositories\OrderRepository;
use App\Supports\Saga\Interfaces\SagaStepInterface;
use App\Supports\Saga\SagaContext;

final class CreateOrderStep implements SagaStepInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
    ) {}

    public function run(SagaContext $context): void
    {
        $order = $this->orderRepository->create([
            'customer_name' => $context->get('customer_name'),
            'customer_email' => $context->get('customer_email'),
            'product' => $context->get('product'),
            'quantity' => $context->get('quantity'),
            'total_price' => $context->get('total_price'),
            'status' => 'pending',
        ]);

        $context->set('order', $order);
    }

    public function rollback(SagaContext $context): void
    {
        /** @var Order|null $order */
        $order = $context->get('order');

        if ($order) {
            $this->orderRepository->updateById($order->id, ['status' => 'failed']);
        }
    }
}
