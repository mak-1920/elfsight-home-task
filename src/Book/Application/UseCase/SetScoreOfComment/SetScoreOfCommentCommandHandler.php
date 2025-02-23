<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\SetScoreOfComment;

use App\Book\Application\DTO\CommentDTO;
use App\Book\Domain\Repository\CommentRepositoryInterface;
use App\Book\Domain\Service\ScoreGetterInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Exception\NotFoundException;

final readonly class SetScoreOfCommentCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private ScoreGetterInterface $scoreGetter,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function __invoke(SetScoreOfCommentCommand $command): CommentDTO
    {
        $comment = $this->commentRepository->findById($command->getCommentId());

        if (null === $comment) {
            throw new NotFoundException("Comment with ID {$command->getCommentId()} not found");
        }

        $score = $this->scoreGetter->get($comment->getText());
        $comment->setScore($score);
        $this->commentRepository->save($comment);

        return new CommentDTO(
            $comment->getAuthorName(),
            $comment->getText(),
            $comment->getScore(),
            $comment->getCreatedAt(),
        );
    }
}
