<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\UserInterface\Http\Api\V1\RegisterAccount;

use App\Foundation\Uuid\Uuid;
use App\Framework\UserInterface\OpenApi\ApiProblem\ProblemDetail\ValidationErrorResponse;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/register', name: 'raffle-demo:account:register', methods: ['POST'])]
#[OA\Post(
    description: 'Creates a new account.',
    summary: 'Register an account',
    tags: ['Accounts'],
)]
#[OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
        ref: new Model(type: RegisterAccountRequest::class),
    ),
)]
#[OA\Response(
    response: Response::HTTP_CREATED,
    description: 'Account successfully registered',
    content: new OA\JsonContent(
        ref: new Model(type: RegisterAccountResponse::class),
    ),
)]
#[ValidationErrorResponse]
final readonly class RegisterAccountController
{
    public function __invoke(RegisterAccountRequest $request): JsonResponse
    {
        $response = new RegisterAccountResponse(
            id: Uuid::v7(),
            firstName: $request->firstName,
            lastName: $request->lastName,
            email: $request->email,
        );

        return new JsonResponse($response->toArray(), status: Response::HTTP_CREATED);
    }
}
