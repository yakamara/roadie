<?php

namespace Yakamara\Roadie\Util;

final class JumperMenu
{
    private const string PLACEHOLDER_PREFIX = '<!-- JUMPER_NAV::';
    private const string PLACEHOLDER_SUFFIX = ' -->';

    /** @var list<array{id: string, label: string, icon: string}> */
    private static array $items = [];

    private static ?string $placeholder = null;

    private static string $heading = '';

    public static function setHeading(string $heading): void
    {
        self::$heading = $heading;
    }

    public static function getHeading(): string
    {
        return self::$heading;
    }

    public static function add(string $id, string $label, string $icon): void
    {
        self::$items[] = ['id' => $id, 'label' => $label, 'icon' => $icon];
    }

    /**
     * @return list<array{id: string, label: string, icon: string}>
     */
    public static function getItems(): array
    {
        return self::$items;
    }

    public static function isEmpty(): bool
    {
        return [] === self::$items;
    }

    public static function placeholder(): string
    {
        if (null === self::$placeholder) {
            self::$placeholder = self::PLACEHOLDER_PREFIX . uniqid('', true) . self::PLACEHOLDER_SUFFIX;
        }

        return self::$placeholder;
    }

    public static function replacePlaceholder(string $content, string $renderedNav): string
    {
        if (null === self::$placeholder) {
            return $content;
        }

        return str_replace(self::$placeholder, $renderedNav, $content);
    }
}
