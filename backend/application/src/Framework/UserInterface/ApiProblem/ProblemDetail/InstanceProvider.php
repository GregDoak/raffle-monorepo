<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem\ProblemDetail;

interface InstanceProvider
{
    public function getInstance(): string;
}
