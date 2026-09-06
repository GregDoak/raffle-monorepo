<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\UserInterface\Http\Api\V1\RegisterAccount;

use App\Foundation\Uuid\Uuid;
use App\Framework\Application\Command\CommandBus;
use App\Framework\UserInterface\Hal\HalJsonResponse;
use App\Framework\UserInterface\Hal\HalSerializer;
use App\Framework\UserInterface\OpenApi\ApiProblem\ProblemDetail\ValidationErrorResponse;
use App\Framework\UserInterface\OpenApi\Hal\HalResponse;
use App\RaffleDemo\Account\Application\Command\CreateUsernamePasswordAccount\CreateUsernamePasswordAccountCommand;
use App\RaffleDemo\Account\Application\Command\RecordSuccessfulLogin\RecordSuccessfulLoginCommand;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
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
#[HalResponse(
    response: Response::HTTP_CREATED,
    description: 'Account successfully registered',
    model: RegisterAccountResponse::class,
    baseUrlParameter: 'BASE_BACKEND_URL',
    links: [
        'self' => ['href' => self::SELF_HREF],
        'next' => ['href' => self::NEXT_HREF],
    ],
)]
#[ValidationErrorResponse]
final readonly class RegisterAccountController
{
    private const string SELF_HREF = '/api/accounts/me';
    private const string NEXT_HREF = '/api/accounts/login';

    public function __construct(
        private CommandBus $commandBus,
        private HalSerializer $halSerializer,
    ) {
    }

    public function __invoke(RegisterAccountRequest $request): HalJsonResponse
    {
        $createUsernamePasswordAccountCommand = CreateUsernamePasswordAccountCommand::create(
            firstName: $request->firstName,
            lastName: $request->lastName,
            emailAddress: $request->emailAddress,
            hashedPassword: $request->hashedPassword,
            correlationId: Uuid::v7(), // todo get from request
        );

        $this->commandBus->dispatchSync($createUsernamePasswordAccountCommand);

        $this->commandBus->dispatchSync(
            RecordSuccessfulLoginCommand::fromUsernamePassword(
                accountId: $createUsernamePasswordAccountCommand->id->toString(),
                correlationId: Uuid::v7(), // todo get from request
            ),
        );

        $response = new RegisterAccountResponse(
            id: Uuid::v7(),
            firstName: $request->firstName,
            lastName: $request->lastName,
            emailAddress: $request->emailAddress,
        );

        return new HalJsonResponse(
            $this->halSerializer
                ->withLink('self', self::SELF_HREF)
                ->withLink('next', self::NEXT_HREF)
                ->withResource($response->toArray()),
            status: Response::HTTP_CREATED,
        );
    }
}
