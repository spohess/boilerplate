<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Supports\Saga\SagaContext;
use App\Supports\Saga\Interfaces\SagaStepInterface;
use RuntimeException;

final class FailingStep implements SagaStepInterface
{
    public function run(SagaContext $context): void
    {
        throw new RuntimeException('Step failed intentionally.');
    }

    public function rollback(SagaContext $context): void
    {
        //
    }
}
