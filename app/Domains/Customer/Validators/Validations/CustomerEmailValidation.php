<?php

declare(strict_types=1);

namespace App\Domains\Customer\Validators\Validations;

use App\Domains\Customer\Exceptions\CustomerInvalidException;
use App\Supports\Interfaces\ValidatorInterface;
use Illuminate\Support\Arr;

final class CustomerEmailValidation implements ValidatorInterface
{
    public function validate(array $target): void
    {
        $email = Arr::get($target, 'customer_email');

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new CustomerInvalidException('A valid customer email is required');
        }
    }
}
