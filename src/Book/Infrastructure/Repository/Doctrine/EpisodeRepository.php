<?php

namespace App\Book\Infrastructure\Repository\Doctrine;

use App\Book\Domain\Model\Episode;
use App\Book\Domain\Repository\EpisodeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Episode>
 */
final class EpisodeRepository extends ServiceEntityRepository implements EpisodeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Episode::class);
    }

    public function findById(int $id): ?Episode
    {
        return $this->find($id);
    }
}
