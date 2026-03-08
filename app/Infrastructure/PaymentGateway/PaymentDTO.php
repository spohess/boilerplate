<?php

declare(strict_types=1);

namespace App\Infrastructure\PaymentGateway;

use App\Supports\Interfaces\DTOInterface;

final class PaymentDTO implements DTOInterface
{
    public function __construct(
        public readonly mixed $amount,
        public readonly string $protocol,
    ) {}

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'protocol' => $this->protocol,
        ];
    }
}
