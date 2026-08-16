<?php

declare(strict_types=1);

namespace App\Framework\Application\Query;

interface QueryBus
{
    public function query(Query $query): Result;
}
