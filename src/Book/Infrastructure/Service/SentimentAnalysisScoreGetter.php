<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Service;

use App\Book\Domain\Service\ScoreGetterInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class SentimentAnalysisScoreGetter implements ScoreGetterInterface
{
    private HttpClientInterface $client;

    public function __construct(
        string $token,
        HttpClientInterface $client,
        private LoggerInterface $logger,
    ) {
        $this->client = $client->withOptions([
            'base_uri' => 'https://api.edenai.run/',
            'headers' => [
                'authorization' => "Bearer {$token}",
                'content-type' => 'application/json',
            ],
        ]);
    }

    public function get(string $text): float
    {
        try {
            $response = $this->getFromServer($text)->getContent();
            /** @var array{google: array{general_sentiment_rate: float|null}} $data */
            $data = json_decode($response, true, 512, JSON_THROW_ON_ERROR);

            if (
                null !== $data['google']['general_sentiment_rate']
            ) {
                return $data['google']['general_sentiment_rate'];
            }

            throw new \Exception("Unsupported response format: {$text}");
        } catch (\Throwable $exception) {
            $this->logger->error("Can't get score for text \"{$text}\": {$exception->getMessage()}");

            throw $exception;
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function getFromServer(string $text): ResponseInterface
    {
        return $this->client->request(
            'POST',
            '/v2/text/sentiment_analysis',
            [
                'json' => [
                    'providers' => 'google',
                    'text' => $text,
                    'language' => 'en',
                ],
            ],
        );
    }
}
