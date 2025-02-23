<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\CreateComment;

final readonly class CreateCommentCommand
{
    public function __construct(
        private int $episodeId,
        private string $text,
        private string $author,
    ) {
    }

    public function getEpisodeId(): int
    {
        return $this->episodeId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }
}
