<?php

namespace App\UserInterface\Http\Rest\Exception;

use RuntimeException;

class RequestValidationException extends RuntimeException
{
    public function __construct(
        string $message,
        private readonly int $statusCode,
        private readonly array $errors
    ) {
        parent::__construct($message);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}