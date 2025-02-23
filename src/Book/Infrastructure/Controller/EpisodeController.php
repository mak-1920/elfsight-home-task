<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Controller;

use App\Book\Application\UseCase\CreateComment\CreateCommentCommand;
use App\Book\Application\UseCase\GetEpisode\GetEpisodeCommand;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Exception\NotFoundException;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class EpisodeController extends BaseController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(ref: '#/components/schemas/Episode'),
    )]
    #[OA\Response(
        response: 404,
        description: 'Episode not found',
        content: new OA\JsonContent(ref: '#/components/schemas/Error'),
    )]
    #[OA\Response(
        response: 400,
        description: 'Error',
        content: new OA\JsonContent(ref: '#/components/schemas/Error'),
    )]
    #[Route(
        path: '/episode/{episodeId}',
        name: 'episode_get',
        methods: ['GET'])
    ]
    public function getEpisode(int $episodeId): JsonResponse
    {
        try {
            $episode = $this->commandBus->execute(new GetEpisodeCommand($episodeId));

            return $this->json($episode);
        } catch (NotFoundException $exception) {
            return $this->errorJson($exception->getMessage(), 404);
        } catch (\Throwable $exception) {
            return $this->errorJson($exception->getMessage(), 400);
        }
    }

    #[OA\RequestBody(
        content: new OA\JsonContent(
            examples: [new OA\Examples(
                example: '123',
                summary: '',
                value: [
                    'text' => 'Some text of comment',
                    'author' => 'Ivanov Ivan',
                ]
            )]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Success',
        content: new OA\JsonContent(ref: '#/components/schemas/Comment'),
    )]
    #[OA\Response(
        response: 404,
        description: 'Episode not found',
        content: new OA\JsonContent(ref: '#/components/schemas/Error'),
    )]
    #[OA\Response(
        response: 400,
        description: 'Error',
        content: new OA\JsonContent(ref: '#/components/schemas/Error'),
    )]
    #[Route(
        path: '/episode/{episodeId}/comment',
        name: 'episode_comment_create',
        methods: ['POST']),
    ]
    public function addComment(int $episodeId, Request $request): JsonResponse
    {
        try {
            $content = $request->getContent();
            /** @var array{text: string, author: string} $data */
            $data = json_decode($content, true);
            $text = $data['text'] ?? '';
            $author = $data['author'] ?? '';

            $comment = $this->commandBus->execute(
                new CreateCommentCommand($episodeId, $text, $author)
            );

            return $this->json($comment);
        } catch (NotFoundException $exception) {
            return $this->errorJson($exception->getMessage(), 404);
        } catch (\Throwable $exception) {
            return $this->errorJson($exception->getMessage(), 400);
        }
    }
}
