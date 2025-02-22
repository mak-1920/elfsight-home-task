<?php

namespace App\Book\Domain\Model;

class Comment
{
    private ?int $id = null;

    private ?string $authorName = null;

    private ?Episode $episode = null;

    private ?float $score = null;

    private ?\DateTimeImmutable $createdAt = null;

    public function __construct(
        string $authorName,
        Episode $episode,
    ) {
        $this->authorName = $authorName;
        $this->episode = $episode;
    }

    public function setScore(?float $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): ?string
    {
        return $this->authorName;
    }

    public function getEpisode(): ?Episode
    {
        return $this->episode;
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
