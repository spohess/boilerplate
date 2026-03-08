<?php

declare(strict_types=1);

namespace App\Supports\Saga\Interfaces;

use App\Supports\Saga\SagaContext;

interface SagaStepInterface
{
    public function run(SagaContext $context): void;

    public function rollback(SagaContext $context): void;
}
