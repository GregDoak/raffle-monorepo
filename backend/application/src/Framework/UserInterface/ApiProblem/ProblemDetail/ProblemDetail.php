<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

abstract readonly class ProblemDetail
{
    /** @param array<string, mixed> $additionalParams */
    public function __construct(
        private string $type,
        private int $status,
        private string $title,
        private string $detail,
        private InstanceProvider $instanceProvider,
        private array $additionalParams = [],
    ) {
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return array_merge(
            [
                'type' => $this->type,
                'status' => $this->status,
                'title' => $this->title,
                'detail' => $this->detail,
                'instance' => $this->instanceProvider->getInstance(),
            ],
            $this->additionalParams,
        );
    }
}
