<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\PersonalData\Repository;

use App\Framework\Domain\Exception\AggregateNotFound;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalData;
use App\RaffleDemo\Account\Domain\PersonalData\Model\PersonalDataAggregateId;

interface PersonalDataRepository
{
    public function store(PersonalData $personalData): void;

    /** @throws AggregateNotFound */
    public function getById(PersonalDataAggregateId $id): PersonalData;
}
