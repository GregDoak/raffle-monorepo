<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem;

use App\Framework\UserInterface\ApiProblem\ProblemDetail\InstanceProvider;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\ProblemDetail;
use Throwable;

final readonly class ProdExceptionTransformer extends AbstractExceptionTransformer
{
    /** @param array<string, mixed> $additionalParams */
    public function __construct(
        InstanceProvider $instanceProvider,
        private array $additionalParams = [],
    ) {
        parent::__construct($instanceProvider);
    }

    public function transform(Throwable $exception): ProblemDetail
    {
        return $this->convertExceptionToProblemDetail($exception, $this->additionalParams);
    }
}
