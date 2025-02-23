<?php

declare(strict_types=1);

namespace App\Book\Domain\Service;

interface ScoreGetterInterface
{
    public function get(string $text): float;
}
