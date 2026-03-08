<?php

declare(strict_types=1);

namespace App\Supports\Factories\Interfaces;

use App\Supports\Interfaces\DomainObjectInterface;

interface FactoryInterface
{
    /** @param array<string, mixed> $data */
    public function makeFromArray(array $data): DomainObjectInterface;
}
