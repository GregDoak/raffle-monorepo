<?php

declare(strict_types=1);

namespace App\Framework\Application\Query\Exception;

use App\Framework\Application\Query\Query;
use RuntimeException;

use function sprintf;

final class QueryNotRegistered extends RuntimeException implements QueryException
{
    public function __construct(Query $query)
    {
        parent::__construct(sprintf('The query "%s" is not registered with a handler', $query::class));
    }
}
