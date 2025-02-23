<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\SetScoreOfComment;

final readonly class SetScoreOfCommentCommand
{
    public function __construct(
        private int $commentId,
    ) {
    }

    public function getCommentId(): int
    {
        return $this->commentId;
    }
}
