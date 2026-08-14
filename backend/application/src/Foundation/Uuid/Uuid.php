<?php

declare(strict_types=1);

namespace App\Foundation\Uuid;

final class Uuid
{
    private static UuidInterface $uuid;

    public static function isValid(string $uuid): bool
    {
        return self::get()::isValid($uuid);
    }

    public static function set(UuidInterface $uuid): void
    {
        self::$uuid = $uuid;
    }

    public static function v4(): string
    {
        return self::get()::v4();
    }

    public static function v7(): string
    {
        return self::get()::v7();
    }

    private static function get(): UuidInterface
    {
        return self::$uuid ??= new SymfonyUuid();
    }
}
