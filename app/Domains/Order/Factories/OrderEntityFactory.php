<?php

declare(strict_types=1);

namespace App\Domains\Order\Factories;

use App\Domains\Order\Entities\OrderEntity;
use App\Supports\Factories\Abstracts\AbstractFactory;

final class OrderEntityFactory extends AbstractFactory
{
    protected string $objectClass = OrderEntity::class;
}
