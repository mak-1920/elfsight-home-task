<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Database\Fixture;

use App\Book\Domain\Repository\EpisodeRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

final class EpisodeFixture extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private readonly EpisodeRepositoryInterface $episodeRepository,
    ) {
    }

    public static function getGroups(): array
    {
        return ['prod', 'dev', 'test'];
    }

    public function load(ObjectManager $manager): void
    {
        $episodes = $this->episodeRepository->findAll();

        foreach ($episodes as $episode) {
            $manager->persist($episode);
        }

        $manager->flush();
    }
}
