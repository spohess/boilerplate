<?php

declare(strict_types=1);

namespace App\Domains\Customer;

use App\Exceptions\CustomerInvalidException;
use App\Supports\Interfaces\ValidatorInterface;

final class CustomerValidator implements ValidatorInterface
{
    public function validate(array $target): void
    {
        $name = Arr::get($target, 'customer_name');
        if (empty($name)) {
            throw new CustomerInvalidException('Customer name is required');
        }

        $email = Arr::get($target, 'customer_email');
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new CustomerInvalidException('A valid customer email is required');
        }
    }
}
