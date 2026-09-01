<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Domain\Token\Model;

use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Token\Exception\InvalidTokenAction;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;
use App\RaffleDemo\Account\Domain\Token\ValueObject\CreatedAt;
use App\RaffleDemo\Account\Domain\Token\ValueObject\ExpiresAt;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Selector;
use App\RaffleDemo\Account\Domain\Token\ValueObject\UpdatedAt;
use App\RaffleDemo\Account\Domain\Token\ValueObject\UsernamePassword\HashedPassword;
use App\RaffleDemo\Account\Domain\Token\ValueObject\UsernamePassword\Username;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Verifier;

final readonly class Token
{
    private function __construct(
        public TokenAggregateId $id,
        public AccountAggregateId $accountId,
        public Context $context,
        public Selector $selector,
        public Verifier $verifier,
        public CreatedAt $createdAt,
        public UpdatedAt $updatedAt,
        public ExpiresAt $expiresAt,
    ) {
    }

    public static function fromNewUsernamePassword(
        AccountAggregateId $accountId,
        Username $username,
        HashedPassword $hashedPassword,
    ): self {
        return new self(
            id: TokenAggregateId::fromNew(),
            accountId: $accountId,
            context: Context::UsernamePassword,
            selector: Selector::fromString($username->toString()),
            verifier: Verifier::fromString($hashedPassword->toString()),
            createdAt: CreatedAt::fromNew(),
            updatedAt: UpdatedAt::fromNull(),
            expiresAt: ExpiresAt::fromNull(),
        );
    }

    /** @throws InvalidTokenAction */
    public function changePassword(Verifier $verifier): self
    {
        if ($this->context !== Context::UsernamePassword) {
            throw InvalidTokenAction::cannotChangePasswordOnContext($this->context);
        }

        return new self(
            id: $this->id,
            accountId: $this->accountId,
            context: $this->context,
            selector: $this->selector,
            verifier: $verifier,
            createdAt: $this->createdAt,
            updatedAt: UpdatedAt::fromNew(),
            expiresAt: $this->expiresAt,
        );
    }

    /**
     * @param array{
     *     id: string,
     *     account_id: string,
     *     context: string,
     *     selector: string,
     *     verifier: string,
     *     created_at: string,
     *     updated_at: ?string,
     *     expires_at: ?string,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: TokenAggregateId::fromString($data['id']),
            accountId: AccountAggregateId::fromString($data['account_id']),
            context: Context::from($data['context']),
            selector: Selector::fromString($data['selector']),
            verifier: Verifier::fromString($data['verifier']),
            createdAt: CreatedAt::fromString($data['created_at']),
            updatedAt: UpdatedAt::fromNullableString($data['updated_at']),
            expiresAt: ExpiresAt::fromNullableString($data['expires_at']),
        );
    }
}
