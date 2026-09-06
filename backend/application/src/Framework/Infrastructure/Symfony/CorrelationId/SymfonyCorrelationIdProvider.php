<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\CorrelationId;

use App\Foundation\Serializer\JsonSerializer;
use App\Foundation\Uuid\Uuid;
use App\Framework\UserInterface\CorrelationId\CorrelationIdProvider;
use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use function is_array;
use function is_string;

final readonly class SymfonyCorrelationIdProvider implements CorrelationIdProvider
{
    private const string LAMBDA_INVOCATION_CONTEXT = 'LAMBDA_INVOCATION_CONTEXT';

    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function provide(): string
    {
        return $this->getAwsRequestId() ?? Uuid::v7();
    }

    private function getAwsRequestId(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request instanceof Request === false) {
            return null;
        }

        $lambdaInvocationContext = $request->server->get(self::LAMBDA_INVOCATION_CONTEXT);

        if (is_string($lambdaInvocationContext) === false) {
            return null;
        }

        try {
            $context = JsonSerializer::deserialize($lambdaInvocationContext);
        } catch (JsonException) {
            return null;
        }

        $awsRequestId = is_array($context) ? $context['awsRequestId'] ?? null : null;

        return is_string($awsRequestId) && $awsRequestId !== '' ? $awsRequestId : null;
    }
}
