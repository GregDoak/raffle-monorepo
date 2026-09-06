<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

enum LoginResultType: string
{
    case Succeeded = 'SUCCEEDED';
}
