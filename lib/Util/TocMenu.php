<?php

namespace Yakamara\Roadie\Util;

final class TocMenu
{
    private static array $items = [];

    public static function add(string $id, string $title, ?string $kicker = null): void
    {
        self::$items[] = ['id' => $id, 'title' => $title, 'kicker' => $kicker];
    }

    public static function getItems(): array
    {
        return self::$items;
    }

    public static function isEmpty(): bool
    {
        return self::$items === [];
    }
}
