<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Repository\Api;

use App\Book\Domain\Model\Episode;
use App\Book\Domain\Repository\EpisodeRepositoryInterface;
use App\Shared\Application\Exception\RepositoryException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class EpisodeRepository implements EpisodeRepositoryInterface
{
    private HttpClientInterface $client;

    public function __construct(
        HttpClientInterface $client,
        private LoggerInterface $logger,
    ) {
        $this->client = $client->withOptions([
            'base_uri' => 'https://rickandmortyapi.com/',
            'headers' => [
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * @return Episode[]
     *
     * @throws RepositoryException
     */
    public function findAll(): array
    {
        $episodes = [];
        /** @var array{info: array, results: array}|null $data */
        $data = null;

        do {
            if (
                is_array($data)
                && null !== $data['info']['next']
            ) {
                /** @var string $path */
                $path = $data['info']['next'];
            } else {
                $path = '/api/episode';
            }

            $response = $this->request(
                path: $path,
            );

            /** @var array{info: array, results: array} $data */
            $data = json_decode($response, true);

            /** @var array{id: int, name: string, air_date: string} $result */
            foreach ($data['results'] as $result) {
                $episodes[] = $this->convertJsonToEntity($result);
            }
        } while (null !== $data['info']['next']);

        return $episodes;
    }

    /**
     * @throws RepositoryException
     */
    public function findById(int $id): ?Episode
    {
        $response = $this->request(
            path: "/api/episode/{$id}",
        );

        /** @var array{id: int, name: string, air_date: string} $data */
        $data = json_decode($response, true);

        return $this->convertJsonToEntity($data);
    }

    /**
     * @param array{id: int, name: string, air_date: string} $data
     */
    private function convertJsonToEntity(array $data): Episode
    {
        try {
            $date = new \DateTimeImmutable($data['air_date']);
        } catch (\DateMalformedStringException $exception) {
            $this->logger->error("Unconverted date for episode with id {$data['id']}");
            $date = new \DateTimeImmutable();
        }

        return new Episode(
            $data['name'],
            $date,
            $data['id'],
        );
    }

    /**
     * @throws RepositoryException
     */
    private function request(
        string $path = '/',
    ): string {
        try {
            $response = $this->client->request(
                'GET',
                $path,
            );

            return $response->getContent();
        } catch (\Throwable $exception) {
            $errorMessage = "Request execution error ({$path}): {$exception->getMessage()}";
            $this->logger->error($errorMessage);

            throw new RepositoryException($errorMessage, 0, $exception);
        }
    }
}
