<?php

declare(strict_types=1);

namespace App\Framework\Application\Query;

interface Result
{
    /** @return mixed[] */
    public function serialize(): array;
}
