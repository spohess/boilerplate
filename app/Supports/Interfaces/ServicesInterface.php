<?php

declare(strict_types=1);

namespace App\Supports\Interfaces;

interface ServicesInterface
{
    /** @param array<string, mixed> $data */
    public function execute(array $data): DTOInterface;
}
