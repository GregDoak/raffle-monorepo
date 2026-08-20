<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\UserInterface\Http\Api\V1\RegisterAccount;

use OpenApi\Attributes as OA;

#[OA\Schema(
    title: 'Register Account Response',
    description: 'Response returned after successfully registering an account.',
)]
final readonly class RegisterAccountResponse
{
    public function __construct(
        #[OA\Property(
            description: 'The account identifier.',
            example: '018f4b3e-6c2a-7a3e-8b1a-2f6c8e9d1a2b',
        )]
        public string $id,
        #[OA\Property(
            description: 'The account first name.',
            example: 'John',
        )]
        public string $firstName,
        #[OA\Property(
            description: 'The account last name.',
            example: 'Smith',
        )]
        public string $lastName,
        #[OA\Property(
            description: 'The account email address.',
            example: 'john.smith@example.com',
        )]
        public string $email,
    ) {
    }

    /** @return array{id: string, first_name: string, last_name: string, email: string} */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }
}
