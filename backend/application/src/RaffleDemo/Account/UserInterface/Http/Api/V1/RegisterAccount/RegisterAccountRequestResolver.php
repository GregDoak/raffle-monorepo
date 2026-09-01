<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\UserInterface\Http\Api\V1\RegisterAccount;

use App\Foundation\Serializer\JsonSerializer;
use App\Framework\UserInterface\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final readonly class RegisterAccountRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private Validator $validator,
        private PasswordHasherFactoryInterface $passwordHasherFactory,
    ) {
    }

    /** @return RegisterAccountRequest[] */
    public function resolve(
        Request $request,
        ArgumentMetadata $argument,
    ): iterable {
        if ($argument->getType() !== RegisterAccountRequest::class) {
            return [];
        }

        /** @var array{first_name?: string, last_name?: string, email_address?: string, password?: string} $data */
        $data = JsonSerializer::deserialize($request->getContent());

        // Holds the plain password only long enough to run constraint checks (min length etc.) before hashing.
        $registerAccountRequest = new RegisterAccountRequest(
            firstName: $data['first_name'] ?? '',
            lastName: $data['last_name'] ?? '',
            emailAddress: $data['email_address'] ?? '',
            hashedPassword: $data['password'] ?? '',
        );

        $this->validator->validate($registerAccountRequest);

        yield new RegisterAccountRequest(
            firstName: $registerAccountRequest->firstName,
            lastName: $registerAccountRequest->lastName,
            emailAddress: $registerAccountRequest->emailAddress,
            hashedPassword: $this->passwordHasherFactory
                ->getPasswordHasher('account')
                ->hash($registerAccountRequest->hashedPassword),
        );
    }
}
