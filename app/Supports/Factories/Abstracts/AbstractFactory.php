<?php

declare(strict_types=1);

namespace App\Supports\Factories\Abstracts;

use App\Supports\Factories\Interfaces\FactoryInterface;
use App\Supports\Interfaces\DomainObjectInterface;
use Illuminate\Support\Arr;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

abstract class AbstractFactory implements FactoryInterface
{
    /** @var class-string<DomainObjectInterface> */
    protected string $objectClass;

    /** @param array<string, mixed> $data */
    public function makeFromArray(array $data): DomainObjectInterface
    {
        if (! isset($this->objectClass)) {
            throw new RuntimeException(static::class . ' must define the $objectClass property.');
        }

        $object = app($this->objectClass);

        $reflection = new ReflectionClass($object);

        foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();

            if (Arr::exists($data, $name)) {
                $property->setValue($object, $data[$name]);
            }
        }

        return $object;
    }
}
