<?php

declare(strict_types=1);

namespace App\Domains\Order\Steps;

use App\Domains\Order\Models\Order;
use App\Domains\Order\Repositories\OrderRepository;
use App\Infrastructure\PaymentGateway\PaymentDTO;
use App\Infrastructure\PaymentGateway\PaymentService;
use App\Infrastructure\PaymentGateway\RefundService;
use App\Supports\Saga\SagaContext;
use App\Supports\Saga\SagaStepInterface;

final class ProcessPaymentStep implements SagaStepInterface
{
    public function __construct(
        private PaymentService $paymentService,
        private RefundService $refundService,
        private OrderRepository $orderRepository,
    ) {}

    public function run(SagaContext $context): void
    {
        /** @var Order $order */
        $order = $context->get('order');

        /** @var PaymentDTO $payment */
        $payment = $this->paymentService->execute([
            'order_id' => $order->id,
            'customer_email' => $order->customer_email,
            'product' => $order->product,
        ]);

        $this->orderRepository->updateById($order->id, ['amount' => $payment->amount]);

        $context->set('amount', $payment->amount);
    }

    public function rollback(SagaContext $context): void
    {
        $amount = $context->get('amount');

        if ($amount) {
            $this->refundService->execute(['amount' => $amount]);
        }
    }
}
