<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\UserInterface\Http\Api\V1\RegisterAccount;

use OpenApi\Attributes as OA;
use SensitiveParameter;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    title: 'Register Account Request',
    description: 'Request used to register a new account.',
)]
final readonly class RegisterAccountRequest
{
    public function __construct(
        #[SensitiveParameter]
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        #[OA\Property(
            description: 'The account first name.',
            example: 'John',
            maxLength: 100,
        )]
        public string $firstName,
        #[SensitiveParameter]
        #[Assert\NotBlank]
        #[Assert\Length(max: 100)]
        #[OA\Property(
            description: 'The account last name.',
            example: 'Smith',
            maxLength: 100,
        )]
        public string $lastName,
        #[SensitiveParameter]
        #[Assert\NotBlank]
        #[Assert\Email]
        #[OA\Property(
            description: 'The account email address.',
            example: 'john.smith@example.com',
        )]
        public string $email,
        #[SensitiveParameter]
        #[Assert\NotBlank]
        #[Assert\Length(min: 8)]
        #[OA\Property(
            description: 'The account password.',
            example: 'correct-horse-battery-staple',
            minLength: 8,
        )]
        public string $password,
    ) {
    }
}
