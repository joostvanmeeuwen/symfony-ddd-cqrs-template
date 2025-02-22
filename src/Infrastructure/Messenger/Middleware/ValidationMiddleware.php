<?php

namespace App\Infrastructure\Messenger\Middleware;

use App\Application\Exception\ValidationException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ValidationMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        $violations = $this->validator->validate($message);

        if (count($violations) > 0) {
            throw new ValidationException($violations);
        }

        return $stack->next()->handle($envelope, $stack);
    }
}