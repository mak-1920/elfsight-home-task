<?php

namespace App\Book\Infrastructure\Repository\Doctrine;

use App\Book\Domain\Model\Comment;
use App\Book\Domain\Repository\CommentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
final class CommentRepository extends ServiceEntityRepository implements CommentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function save(Comment $comment): Comment
    {
        $this->getEntityManager()->persist($comment);
        $this->getEntityManager()->flush();

        return $comment;
    }

    public function findByEpisode(int $episodeId, int $count = 0): array
    {
        $qb = $this
            ->createQueryBuilder('comment')
            ->where('comment.episode = :episode')
            ->setParameter('episode', $episodeId)
            ->orderBy('comment.id', 'DESC')
        ;

        if ($count > 0) {
            $qb->setMaxResults($count);
        }

        return $qb->getQuery()->getResult();
    }

    public function getAvgScoreByEpisode(int $episodeId): float
    {
        $score = $this->createQueryBuilder('comment')
            ->select('AVG(comment.score)')
            ->where('comment.episode = :episode')
            ->andWhere('comment.score IS NOT NULL')
            ->setParameter('episode', $episodeId)
            ->getQuery()
            ->getSingleScalarResult() ?? 0
        ;

        return round($score, 4);
    }

    public function findById(int $commentId): ?Comment
    {
        return $this->find($commentId);
    }
}
