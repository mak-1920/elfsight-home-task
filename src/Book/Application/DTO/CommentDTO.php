<?php

declare(strict_types=1);

namespace App\Book\Application\DTO;

final readonly class CommentDTO
{
    public function __construct(
        private string $authorName,
        private string $text,
        private ?float $score,
        private \DateTimeImmutable $createdAt,
    ) {
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
}
