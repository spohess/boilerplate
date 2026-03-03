<?php

declare(strict_types=1);

namespace App\Supports\Validators;

use App\Supports\Exceptions\ValidatorException;

interface CheckInterface
{
    /**
     * @param array $target
     * @throws ValidatorException
     */
    public function handle(array $target): void;
}
