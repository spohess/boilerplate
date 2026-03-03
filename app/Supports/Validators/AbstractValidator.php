<?php

declare(strict_types=1);

namespace App\Supports\Validators;

use App\Supports\Interfaces\ValidatorInterface;

abstract class AbstractValidator implements ValidatorInterface
{
    /** @return class-string<ValidatorInterface>[] */
    abstract protected function validations(): array;

    public function validate(array $target): void
    {
        foreach ($this->validations() as $validation) {
            app($validation)->validate($target);
        }
    }
}
