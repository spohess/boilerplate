<?php

declare(strict_types=1);

namespace App\Supports\Validators;

abstract class AbstractValidator implements ValidatorInterface
{
    /** @return class-string<CheckInterface>[] */
    abstract protected function validations(): array;

    public function validate(array $target): void
    {
        foreach ($this->validations() as $validation) {
            app($validation)->handle($target);
        }
    }
}
