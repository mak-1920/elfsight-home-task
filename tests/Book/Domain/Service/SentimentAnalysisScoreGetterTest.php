<?php

declare(strict_types=1);

namespace App\Tests\Book\Domain\Service;

use App\Book\Infrastructure\Service\SentimentAnalysisScoreGetter;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class SentimentAnalysisScoreGetterTest extends TestCase
{
    public function testFindAll(): void
    {
        $getter = $this->getGetter();

        $score = $getter->get('test');

        $this->assertIsFloat($score);
        $this->assertEquals(0.8, $score);
    }

    private function getGetter(): SentimentAnalysisScoreGetter
    {
        return new SentimentAnalysisScoreGetter(
            '',
            new MockHttpClient(function (string $method, string $url) {
                return match ($url) {
                    'https://api.edenai.run/v2/text/sentiment_analysis' => new MockResponse('{"google":{"general_sentiment":"Negative","general_sentiment_rate":0.8,"items":[{"segment":"it is bad text","sentiment":"Negative","sentiment_rate":0.8}],"status":"success","usage":null,"cost":0.001}}'),
                };
            }),
            $this->createStub(LoggerInterface::class),
        );
    }
}
