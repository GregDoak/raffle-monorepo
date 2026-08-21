<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Hal;

use Symfony\Component\HttpFoundation\JsonResponse;

final class HalJsonResponse extends JsonResponse
{
    public function __construct(HalSerializer $halSerializer, int $status = self::HTTP_OK)
    {
        parent::__construct(
            data: $halSerializer->serialize(),
            status: $status,
            headers: ['Content-Type' => 'application/hal+json'],
            json: true,
        );
    }
}
