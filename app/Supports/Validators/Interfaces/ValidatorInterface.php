<?php

declare(strict_types=1);

namespace App\Supports\Validators\Interfaces;

use App\Supports\Exceptions\ValidatorException;

interface ValidatorInterface
{
    /**
     * @param array $target
     * @return void
     * @throws ValidatorException
     */
    public function validate(array $target): void;
}
