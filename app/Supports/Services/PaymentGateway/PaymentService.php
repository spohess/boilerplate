<?php

declare(strict_types=1);

namespace App\Supports\Services\PaymentGateway;

use App\Supports\Interfaces\DTOInterface;
use App\Supports\Interfaces\ServicesInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class PaymentService implements ServicesInterface
{
    /** @param array<string, mixed> $data */
    public function execute(array $data): DTOInterface
    {
        $response = Http::post('https://external-service.example.com/pay', [
            'order_id' => Arr::get($data, 'order_id'),
            'customer_email' => Arr::get($data, 'customer_email'),
            'product' => Arr::get($data, 'product'),
        ]);

        if ($response->failed()) {
            throw new RuntimeException('External service payment failed.');
        }

        return new PaymentDTO(
            amount: $response->json('amount'),
        );
    }
}
