<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Supports\Queue\Abstracts\AbstractQueueHandler;
use App\Supports\Queue\QueueMessage;

final class AnotherFakeRouterHandler extends AbstractQueueHandler
{
    protected function process(QueueMessage $message): void {}
}
