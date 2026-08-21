<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Router;

use App\Framework\UserInterface\ApiProblem\ProblemDetail\InstanceProvider;
use Symfony\Component\Routing\RouterInterface;

final readonly class SymfonyInstanceProvider implements InstanceProvider
{
    public function __construct(
        private RouterInterface $router,
        private string $baseBackendUrl,
    ) {
    }

    public function getInstance(): string
    {
        return $this->baseBackendUrl.$this->router->getContext()->getPathInfo();
    }
}
