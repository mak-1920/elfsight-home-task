<?php

declare(strict_types=1);

namespace App\Book\Domain\Repository;

use App\Book\Domain\Model\Episode;

interface EpisodeRepositoryInterface
{
    /**
     * @return Episode[]
     */
    public function findAll(): array;

    public function findById(int $id): ?Episode;
}
