<?php

declare(strict_types=1);

namespace App\Supports\Interfaces;

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
