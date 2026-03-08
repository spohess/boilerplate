<?php

declare(strict_types=1);

namespace App\Domains\Customer\Validators;

use App\Domains\Customer\Validators\Validations\CustomerEmailValidation;
use App\Domains\Customer\Validators\Validations\CustomerNameValidation;
use App\Supports\Validators\Abstracts\AbstractValidator;

final class CustomerValidator extends AbstractValidator
{
    protected function validations(): array
    {
        return [
            CustomerNameValidation::class,
            CustomerEmailValidation::class,
        ];
    }
}
