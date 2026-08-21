<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem;

use App\Framework\Application\Command\Exception\ValidationErrors as ApplicationCommandValidationErrors;
use App\Framework\Application\Query\Exception\ValidationErrors as ApplicationQueryValidationErrors;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\ForbiddenProblemDetail;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\InstanceProvider;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\InternalServerErrorProblemDetail;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\MethodNotAllowedProblemDetail;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\NotFoundProblemDetail;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\ProblemDetail;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\UnauthorizedProblemDetail;
use App\Framework\UserInterface\ApiProblem\ProblemDetail\ValidationProblemDetail;
use App\Framework\UserInterface\Exception\ValidationErrors as UserInterfaceValidationErrors;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;
use Throwable;

abstract readonly class AbstractExceptionTransformer implements ExceptionTransformer
{
    public function __construct(
        private InstanceProvider $instanceProvider,
    ) {
    }

    /** @param array<string, mixed> $additionalParams */
    protected function convertExceptionToProblemDetail(
        Throwable $exception,
        array $additionalParams = [],
    ): ProblemDetail {
        if ($exception::class === HttpException::class && $exception->getPrevious() !== null) {
            $exception = $exception->getPrevious();
        }

        return match ($exception::class) {
            ApplicationCommandValidationErrors::class => new ValidationProblemDetail(
                $this->instanceProvider,
                array_merge(['errors' => $exception->errors], $additionalParams),
            ),
            ApplicationQueryValidationErrors::class => new ValidationProblemDetail(
                $this->instanceProvider,
                array_merge(['errors' => $exception->errors], $additionalParams),
            ),
            UserInterfaceValidationErrors::class => new ValidationProblemDetail(
                $this->instanceProvider,
                array_merge(['errors' => $exception->errors], $additionalParams),
            ),
            InsufficientAuthenticationException::class => new UnauthorizedProblemDetail($this->instanceProvider, $additionalParams),
            AccessDeniedException::class => new ForbiddenProblemDetail($this->instanceProvider, $additionalParams),
            NotFoundHttpException::class => new NotFoundProblemDetail($this->instanceProvider, $additionalParams),
            MethodNotAllowedHttpException::class => new MethodNotAllowedProblemDetail(
                $this->instanceProvider, $additionalParams,
            ),
            default => new InternalServerErrorProblemDetail($this->instanceProvider, $additionalParams),
        };
    }
}
