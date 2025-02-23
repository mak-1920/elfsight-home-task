<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\CreateComment;

use App\Book\Application\DTO\CommentDTO;
use App\Book\Application\UseCase\SetScoreOfComment\SetScoreOfCommentCommand;
use App\Book\Domain\Model\Comment;
use App\Book\Domain\Repository\CommentRepositoryInterface;
use App\Book\Domain\Repository\EpisodeRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Exception\NotFoundException;

final readonly class CreateCommentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private EpisodeRepositoryInterface $episodeRepository,
        private CommentRepositoryInterface $commentRepository,
        private CommandBusInterface $bus,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(CreateCommentCommand $command): CommentDTO
    {
        $episode = $this->episodeRepository->findById($command->getEpisodeId());

        if (null === $episode) {
            throw new NotFoundException("Episode with ID {$command->getEpisodeId()} not found");
        }

        $comment = new Comment(
            $command->getAuthor(),
            $command->getText(),
            $episode,
        );

        $comment = $this->commentRepository->save($comment);

        $this->bus->execute(new SetScoreOfCommentCommand($comment->getId()));

        return new CommentDTO(
            $comment->getAuthorName(),
            $comment->getText(),
            $comment->getScore(),
            $comment->getCreatedAt(),
        );
    }
}
