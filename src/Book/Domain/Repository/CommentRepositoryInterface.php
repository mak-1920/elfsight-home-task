<?php

declare(strict_types=1);

namespace App\Book\Domain\Repository;

use App\Book\Domain\Model\Comment;

interface CommentRepositoryInterface
{
    public function save(Comment $comment): Comment;

    /**
     * @return Comment[]
     */
    public function findByEpisode(int $episodeId, int $count = 0): array;

    public function getAvgScoreByEpisode(int $episodeId): float;

    public function findById(int $commentId): ?Comment;
}
