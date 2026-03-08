<?php

declare(strict_types=1);

namespace App\Supports\Saga\Interfaces;

use App\Supports\Saga\SagaContext;

interface StepEventInterface
{
    public function event(SagaContext $context): object;
}
