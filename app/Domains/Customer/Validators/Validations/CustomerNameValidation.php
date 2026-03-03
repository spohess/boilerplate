<?php

declare(strict_types=1);

namespace App\Domains\Customer\Validators\Validations;

use App\Domains\Customer\Exceptions\CustomerInvalidException;
use App\Supports\Validators\CheckInterface;
use Illuminate\Support\Arr;

final class CustomerNameValidation implements CheckInterface
{
    public function handle(array $target): void
    {
        $name = Arr::get($target, 'customer_name');

        if (empty($name)) {
            throw new CustomerInvalidException('Customer name is required');
        }
    }
}
