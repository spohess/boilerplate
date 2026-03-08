<?php

declare(strict_types=1);

namespace App\Domains\Order\Entities;

use App\Supports\Interfaces\DomainObjectInterface;

final class OrderEntity implements DomainObjectInterface
{
    public string $protocol;

    public string $customer_name;

    public string $customer_email;

    public string $product;

    public int $quantity;

    public int $total_price;

    public function taxRate(): int
    {
        return match (true) {
            $this->total_price <= 5000 => 0,
            $this->total_price <= 30000 => 3,
            default => 7,
        };
    }

    public function taxAmount(): int
    {
        return (int) round($this->total_price * $this->taxRate() / 100);
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'protocol' => $this->protocol,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'product' => $this->product,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'tax_rate' => $this->taxRate(),
            'tax_amount' => $this->taxAmount(),
        ];
    }
}
