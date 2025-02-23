<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class NotFoundException extends \Exception implements ExceptionInterface
{
}
