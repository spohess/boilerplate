<?php

declare(strict_types=1);

namespace App\Supports\Exceptions;

use Exception;

class ValidatorException extends Exception
{
    protected $message = 'Validation failed';

    protected $code = 422;

    public function __construct($message = null, $code = null)
    {
        if ($message) {
            $this->message = $message;
        }

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code);
    }
}
