<?php

declare(strict_types=1);

namespace App\Book\Infrastructure\Controller;

use App\Book\Infrastructure\Model\ErrorResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    protected function errorJson(string $message, int $code): JsonResponse
    {
        return $this->json(new ErrorResponse($message, $code), $code);
    }
}
