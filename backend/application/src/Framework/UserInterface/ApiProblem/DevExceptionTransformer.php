<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\ApiProblem;

use App\Framework\UserInterface\ApiProblem\ProblemDetail\ProblemDetail;
use Throwable;

final readonly class DevExceptionTransformer extends AbstractExceptionTransformer
{
    public function transform(Throwable $exception): ProblemDetail
    {
        $previousMessages = [];
        $previous = $exception;
        while ($previous = $previous->getPrevious()) {
            $previousMessages[] = $this->serializeException($previous);
        }

        $additionalParams = [
            'exception' => array_merge(
                $this->serializeException($exception),
                [
                    'previous' => $previousMessages,
                ],
            ),
        ];

        return $this->convertExceptionToProblemDetail($exception, $additionalParams);
    }

    /** @return array{type:string, message: string, code: int, line:int, file: string, trace: string[]} */
    private function serializeException(Throwable $throwable): array
    {
        return [
            'type' => $throwable::class,
            'message' => $throwable->getMessage(),
            'code' => $throwable->getCode(),
            'line' => $throwable->getLine(),
            'file' => $throwable->getFile(),
            'trace' => explode("\n", $throwable->getTraceAsString()),
        ];
    }
}
