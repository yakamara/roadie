<?php

namespace Yakamara\Roadie\Article;

/**
 * Registry für Artikel-Key-Enums.
 *
 * Projekte registrieren ihr Enum einmalig in boot.php:
 *
 *   ArticleKeyRegistry::register(ArticleKey::class, 'project');
 *
 * @see README.md – Abschnitt "ArticleKey"
 */
class ArticleKeyRegistry
{
    /** @var array<class-string<\BackedEnum>, string> enum class => config namespace */
    private static array $registry = [];

    /**
     * @param class-string<\BackedEnum> $enumClass
     */
    public static function register(string $enumClass, string $namespace): void
    {
        self::$registry[$enumClass] = $namespace;
    }

    /**
     * @return array<class-string<\BackedEnum>, string>
     */
    public static function all(): array
    {
        return self::$registry;
    }

    /**
     * @param class-string<\BackedEnum> $enumClass
     */
    public static function getNamespace(string $enumClass): ?string
    {
        return self::$registry[$enumClass] ?? null;
    }
}
