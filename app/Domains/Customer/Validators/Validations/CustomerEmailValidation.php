<?php

declare(strict_types=1);

namespace App\Domains\Customer\Validators\Validations;

use App\Domains\Customer\Exceptions\CustomerInvalidException;
use App\Supports\Validators\CheckInterface;
use Illuminate\Support\Arr;

final class CustomerEmailValidation implements CheckInterface
{
    public function handle(array $target): void
    {
        $email = Arr::get($target, 'customer_email');

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new CustomerInvalidException('A valid customer email is required');
        }
    }
}
