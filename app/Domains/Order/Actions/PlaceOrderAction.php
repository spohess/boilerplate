<?php

declare(strict_types=1);

namespace App\Domains\Order\Actions;

use App\Domains\Order\Steps\ConfirmOrderStep;
use App\Domains\Order\Steps\CreateOrderStep;
use App\Domains\Order\Steps\ProcessPaymentStep;
use App\Models\Order;
use App\Supports\Interfaces\ActionInterface;
use App\Supports\Saga\SagaContext;
use App\Supports\Saga\SagaOrchestrator;

final class PlaceOrderAction implements ActionInterface
{
    public function __construct(
        private SagaContext $context,
        private SagaOrchestrator $orchestrator,
    ) {}

    /** @param array<string, mixed> $data */
    public function execute(array $data): Order
    {
        $this->context->setFromArray($data);

        $this->orchestrator
            ->addStep(CreateOrderStep::class)
            ->addStep(ProcessPaymentStep::class, retries: 3, sleep: 10)
            ->addStep(ConfirmOrderStep::class)
            ->execute($this->context);

        /** @var Order $order */
        $order = $this->context->get('order');

        return $order->fresh();
    }
}
