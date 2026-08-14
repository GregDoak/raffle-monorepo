<?php

declare(strict_types=1);

namespace App\Framework\Domain\Projection;

use App\Framework\Domain\Exception\InvalidProjectorName;
use App\Framework\Domain\ValueObject\AbstractString;

final readonly class ProjectorName extends AbstractString
{
    protected function __construct(
        string $value,
    ) {
        if (trim($value) === '') {
            throw InvalidProjectorName::fromEmptyName(self::class);
        }

        parent::__construct($value);
    }
}
