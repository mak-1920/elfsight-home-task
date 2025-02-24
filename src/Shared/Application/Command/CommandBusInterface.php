<?php

declare(strict_types=1);

namespace App\Shared\Application\Command;

interface CommandBusInterface
{
    public function execute(object $command): mixed;
}
