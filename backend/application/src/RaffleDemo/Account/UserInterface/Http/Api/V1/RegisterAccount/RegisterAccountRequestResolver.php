<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\UserInterface\Http\Api\V1\RegisterAccount;

use App\Foundation\Serializer\JsonSerializer;
use App\Framework\UserInterface\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final readonly class RegisterAccountRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private Validator $validator,
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

        /** @var array{first_name?: string, last_name?: string, email?: string, password?: string} $data */
        $data = JsonSerializer::deserialize($request->getContent());

        $registerAccountRequest = new RegisterAccountRequest(
            firstName: $data['first_name'] ?? '',
            lastName: $data['last_name'] ?? '',
            email: $data['email'] ?? '',
            password: $data['password'] ?? '',
        );

        $this->validator->validate($registerAccountRequest);

        yield $registerAccountRequest;
    }
}
