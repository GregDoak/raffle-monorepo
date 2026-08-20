<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Validation;

use App\Framework\UserInterface\Validation\Validator;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class SymfonyValidator implements Validator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    public function validate(object $request): void
    {
        $violations = $this->validator->validate($request);

        if ($violations->count() > 0) {
            throw new ValidationFailedException($request, $violations);
        }
    }
}
