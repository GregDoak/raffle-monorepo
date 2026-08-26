<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

enum AccountRole: string
{
    case AccountUser = 'ROLE_ACCOUNT_USER';
}
