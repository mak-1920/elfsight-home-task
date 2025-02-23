<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\GetEpisode;

use App\Book\Application\DTO\CommentDTO;
use App\Book\Application\DTO\EpisodeDTO;
use App\Book\Domain\Model\Comment;
use App\Book\Domain\Repository\CommentRepositoryInterface;
use App\Book\Domain\Repository\EpisodeRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Exception\NotFoundException;

final readonly class GetEpisodeCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EpisodeRepositoryInterface $episodeRepository,
        private CommentRepositoryInterface $commentRepository,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(GetEpisodeCommand $command): EpisodeDTO
    {
        $episode = $this->episodeRepository->findById($command->getEpisodeId());

        if (null === $episode) {
            throw new NotFoundException("Episode with ID {$command->getEpisodeId()} not found");
        }

        return new EpisodeDTO(
            $episode->getName(),
            $episode->getAirDate(),
            $this->commentRepository->getAvgScoreByEpisode($command->getEpisodeId()),
            array_map(
                fn (Comment $comment) => new CommentDTO(
                    $comment->getAuthorName(),
                    $comment->getText(),
                    $comment->getScore(),
                    $comment->getCreatedAt(),
                ),
                $this->commentRepository->findByEpisode($command->getEpisodeId(), 3),
            )
        );
    }
}
