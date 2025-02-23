<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Model;

final readonly class ErrorResponse
{
    public function __construct(
        private string $message,
        private int $code,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
