<?php

declare(strict_types=1);

namespace App\Supports\Services\Notification;

use App\Supports\Interfaces\DTOInterface;
use App\Supports\Interfaces\ServicesInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Throwable;

final class NotificationService implements ServicesInterface
{
    /** @param array<string, mixed> $data */
    public function execute(array $data): DTOInterface
    {
        try {
            $response = Http::timeout(5)->retry(2, 100)->post('https://external-service.example.com/notify', [
                'email' => Arr::get($data, 'email'),
                'subject' => Arr::get($data, 'subject'),
                'message' => Arr::get($data, 'message'),
            ]);

            return new NotificationDTO(
                sent: $response->successful(),
            );
        } catch (Throwable $e) {
            report($e);

            return new NotificationDTO(
                sent: false,
            );
        }
    }
}
