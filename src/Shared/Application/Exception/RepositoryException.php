<?php

declare(strict_types=1);

namespace App\Shared\Application\Exception;

use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

class RepositoryException extends \Exception implements ExceptionInterface
{
}
