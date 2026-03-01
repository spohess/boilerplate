<?php

declare(strict_types=1);

namespace App\Supports\Services\PaymentGateway;

use App\Supports\Interfaces\DTOInterface;
use App\Supports\Interfaces\ServicesInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

final class RefundService implements ServicesInterface
{
    /** @param array<string, mixed> $data */
    public function execute(array $data): DTOInterface
    {
        $response = Http::post('https://external-service.example.com/refund', [
            'amount' => Arr::get($data, 'amount'),
        ]);

        return new RefundDTO(
            protocol: (string) $response->json('protocol'),
        );
    }
}
