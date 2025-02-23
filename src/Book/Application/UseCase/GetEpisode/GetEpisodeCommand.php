<?php

declare(strict_types=1);

namespace App\Book\Application\UseCase\GetEpisode;

final readonly class GetEpisodeCommand
{
    public function __construct(
        private int $episodeId,
    ) {
    }

    public function getEpisodeId(): int
    {
        return $this->episodeId;
    }
}
