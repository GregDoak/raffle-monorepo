<?php

declare(strict_types=1);

namespace App\Framework\UserInterface\Validation;

use App\Framework\UserInterface\Exception\ValidationErrors;

interface Validator
{
    /** @throws ValidationErrors */
    public function validate(object $request): void;
}
