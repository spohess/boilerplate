<?php

declare(strict_types=1);

namespace App\Domains\Order\Handlers;

use App\Infrastructure\Notification\NotificationService;
use App\Supports\Queue\Abstracts\AbstractQueueHandler;
use App\Supports\Queue\QueueMessage;

final class SendOrderNotificationHandler extends AbstractQueueHandler
{
    protected function process(QueueMessage $message): void
    {
        $data = $message->getData();

        app(NotificationService::class)->execute([
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);
    }
}
