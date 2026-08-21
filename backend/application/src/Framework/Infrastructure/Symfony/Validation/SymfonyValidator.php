<?php

declare(strict_types=1);

namespace App\Framework\Infrastructure\Symfony\Validation;

use App\Framework\UserInterface\Exception\ValidationErrors;
use App\Framework\UserInterface\Validation\Validator;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class SymfonyValidator implements Validator
{
    public function __construct(
        private ValidatorInterface $validator,
        private NameConverterInterface $nameConverter,
    ) {
    }

    public function validate(object $request): void
    {
        $violations = $this->validator->validate($request);

        if ($violations->count() > 0) {
            throw ValidationErrors::fromErrors($this->convertViolationsToErrors($violations));
        }
    }

    /** @return array<string, string[]> */
    private function convertViolationsToErrors(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        foreach ($violations as $violation) {
            $field = $this->nameConverter->normalize($violation->getPropertyPath());
            $errors[$field][] = (string) $violation->getMessage();
        }

        return $errors;
    }
}
