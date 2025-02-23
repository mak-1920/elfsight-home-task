<?php

declare(strict_types=1);

namespace App\Book\Application\DTO;

final readonly class EpisodeDTO
{
    /**
     * @param CommentDTO[] $comments
     */
    public function __construct(
        private string $name,
        private \DateTimeImmutable $airDate,
        private float $avgScore,
        private array $comments,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAirDate(): \DateTimeImmutable
    {
        return $this->airDate;
    }

    public function getAvgScore(): float
    {
        return $this->avgScore;
    }

    /**
     * @return CommentDTO[]
     */
    public function getComments(): array
    {
        return $this->comments;
    }
}
