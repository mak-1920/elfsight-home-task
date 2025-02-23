<?php

namespace App\Book\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Episode
{
    private int $id;

    private string $name;

    private \DateTimeImmutable $airDate;

    /** @var Collection<int, Comment> */
    private Collection $comments;

    private float $avgScore = 0;

    public function __construct(
        string $name,
        \DateTimeImmutable $airDate,
        ?int $id = null,
    ) {
        if (null !== $id) {
            $this->id = $id;
        }

        $this->name = $name;
        $this->airDate = $airDate;

        $this->comments = new ArrayCollection();
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        $this->comments->removeElement($comment);

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAirDate(): \DateTimeImmutable
    {
        return $this->airDate;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }
}
