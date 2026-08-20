<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Validation;

interface Validator
{
    public function validate(object $request): void;
}
