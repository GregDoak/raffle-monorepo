<?php

declare(strict_types=1);

namespace App\RaffleDemo\Account\Infrastructure\Postgres\Repository;

use App\Framework\Domain\Exception\AggregateNotFound;
use App\RaffleDemo\Account\Domain\Account\Model\AccountAggregateId;
use App\RaffleDemo\Account\Domain\Token\Exception\DuplicateSelector;
use App\RaffleDemo\Account\Domain\Token\Exception\TokenNotFound;
use App\RaffleDemo\Account\Domain\Token\Model\Token;
use App\RaffleDemo\Account\Domain\Token\Model\TokenAggregateId;
use App\RaffleDemo\Account\Domain\Token\Model\TokenAggregateName;
use App\RaffleDemo\Account\Domain\Token\Repository\TokenRepository;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Context;
use App\RaffleDemo\Account\Domain\Token\ValueObject\Selector;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\DBAL\ParameterType;

final readonly class PostgresTokenRepository implements TokenRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function store(Token $token): void
    {
        $sql = <<<SQL
            INSERT INTO account.token
                (id, account_id, context, is_global_selector, is_account_selector, selector, verifier, created_at, updated_at, expires_at)
            VALUES
                (:id, :account_id, :context, :is_global_selector, :is_account_selector, :selector, :verifier, :created_at, :updated_at, :expires_at)
            ON CONFLICT (id) DO UPDATE SET
                account_id = :account_id,
                context = :context,
                is_global_selector = :is_global_selector,
                is_account_selector = :is_account_selector,
                selector = :selector,
                verifier = :verifier,
                created_at = :created_at,
                updated_at = :updated_at,
                expires_at = :expires_at
        SQL;

        $statement = $this->connection->prepare($sql);

        $statement->bindValue('id', $token->id->toString());
        $statement->bindValue('account_id', $token->accountId->toString());
        $statement->bindValue('context', $token->context->value);
        $statement->bindValue('is_global_selector', $token->context->isGlobalSelector(), ParameterType::BOOLEAN);
        $statement->bindValue('is_account_selector', $token->context->isAccountSelector(), ParameterType::BOOLEAN);
        $statement->bindValue('selector', $token->selector->toString());
        $statement->bindValue('verifier', $token->verifier->toString());
        $statement->bindValue('created_at', $token->createdAt->toString());
        $statement->bindValue('updated_at', $token->updatedAt->toString());
        $statement->bindValue('expires_at', $token->expiresAt->toString());

        try {
            $statement->executeStatement();
        } catch (UniqueConstraintViolationException $exception) {
            throw match (true) {
                $token->context->isGlobalSelector() => DuplicateSelector::fromContext($token->context),
                $token->context->isAccountSelector() => DuplicateSelector::fromContextAndAccountId($token->context, $token->accountId),
                default => $exception,
            };
        }
    }

    public function getById(TokenAggregateId $id): Token
    {
        $sql = <<<SQL
            SELECT
                id,
                account_id,
                context,
                selector,
                verifier,
                created_at,
                updated_at,
                expires_at
            FROM
                account.token
            WHERE
                id = :id
        SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue('id', $id->toString());

        $record = $statement->executeQuery()->fetchAssociative();

        if ($record === false) {
            throw AggregateNotFound::fromAggregateNameAndAggregateId(TokenAggregateName::create(), $id);
        }

        return Token::fromArray($record); // @phpstan-ignore-line argument.type
    }

    public function getByAccountIdAndContext(AccountAggregateId $accountId, Context $context): Token
    {
        $sql = <<<SQL
            SELECT
                id,
                account_id,
                context,
                selector,
                verifier,
                created_at,
                updated_at,
                expires_at
            FROM
                account.token
            WHERE
                account_id = :account_id
                AND context = :context
        SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue('account_id', $accountId->toString());
        $statement->bindValue('context', $context->value);

        $record = $statement->executeQuery()->fetchAssociative();

        if ($record === false) {
            throw TokenNotFound::fromAccountIdAndContext($accountId, $context);
        }

        return Token::fromArray($record); // @phpstan-ignore-line argument.type
    }

    public function getByContextAndSelector(Context $context, Selector $selector): Token
    {
        $sql = <<<SQL
            SELECT
                id,
                account_id,
                context,
                selector,
                verifier,
                created_at,
                updated_at,
                expires_at
            FROM
                account.token
            WHERE
                context = :context
                AND selector = :selector
        SQL;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue('context', $context->value);
        $statement->bindValue('selector', $selector->toString());

        $record = $statement->executeQuery()->fetchAssociative();

        if ($record === false) {
            throw TokenNotFound::fromContext($context);
        }

        return Token::fromArray($record); // @phpstan-ignore-line argument.type
    }
}
