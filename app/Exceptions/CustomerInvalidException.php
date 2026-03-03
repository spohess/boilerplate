<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Supports\Exceptions\ValidatorException;

class CustomerInvalidException extends ValidatorException
{
    protected $message = 'Customer is invalid';

    protected $code = 422;
}
