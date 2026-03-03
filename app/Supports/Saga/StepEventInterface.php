<?php

declare(strict_types=1);

namespace App\Supports\Saga;

interface StepEventInterface
{
    public function event(SagaContext $context): object;
}
