<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Account\ValueObject;

enum AccountStatus: string
{
    case Created = 'CREATED';
    case Disabled = 'DISABLED';
    case Anonymised = 'ANONYMISED';
}
