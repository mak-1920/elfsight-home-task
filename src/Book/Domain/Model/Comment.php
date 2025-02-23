<?php

namespace App\Book\Domain\Model;

class Comment
{
    private int $id;

    private string $authorName;

    private string $text;

    private Episode $episode;

    private ?float $score = null;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $authorName,
        string $text,
        Episode $episode,
    ) {
        $this->authorName = $authorName;
        $this->text = $text;
        $this->episode = $episode;
        $episode->addComment($this);
    }

    public function setScore(?float $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getEpisode(): Episode
    {
        return $this->episode;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
