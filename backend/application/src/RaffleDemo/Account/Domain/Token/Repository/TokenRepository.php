<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Repository;

use App\Framework\Domain\Exception\AggregateNotFound;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Token\Exception\DuplicateSelector;
use App\RaffleDemo\Account\Domain\Token\Exception\TokenNotFound;
use App\RaffleDemo\Account\Domain\Token\Model\Token;
use App\RaffleDemo\Account\Domain\Token\Model\TokenAggregateId;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Selector;

interface TokenRepository
{
    /** @throws DuplicateSelector */
    public function store(Token $token): void;

    /** @throws AggregateNotFound */
    public function getById(TokenAggregateId $id): Token;

    /** @throws TokenNotFound */
    public function getByAccountIdAndContext(AccountAggregateId $accountId, Context $context): Token;

    /** @throws TokenNotFound */
    public function getByContextAndSelector(Context $context, Selector $selector): Token;
}
