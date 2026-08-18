<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem;

use App\Framework\UserInterface\ApiProblem\ProblemDetail\ProblemDetail;
use Throwable;

interface ExceptionTransformer
{
    public function transform(Throwable $exception): ProblemDetail;
}
