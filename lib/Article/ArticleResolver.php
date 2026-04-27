<?php

namespace Yakamara\Roadie\Article;

use BackedEnum;
use InvalidArgumentException;
use rex_article;
use rex_config;

use function array_key_exists;

class ArticleResolver
{
    /** @var array<string, rex_article|null> */
    private static array $cache = [];

    public static function get(BackedEnum $key): ?rex_article
    {
        $cacheKey = $key::class . '::' . $key->value;

        if (!array_key_exists($cacheKey, self::$cache)) {
            $namespace = ArticleKeyRegistry::getNamespace($key::class);
            $id = $namespace ? rex_config::get($namespace, 'article.' . $key->value) : null;
            self::$cache[$cacheKey] = $id ? rex_article::get((int) $id) : null;
        }

        return self::$cache[$cacheKey];
    }

    public static function getUrl(BackedEnum $key, ?int $clang = null, array $params = []): string
    {
        $article = self::get($key);

        return $article ? rex_getUrl($article->getId(), $clang, $params) : '#';
    }

    public static function set(BackedEnum $key, int $articleId): void
    {
        $namespace = ArticleKeyRegistry::getNamespace($key::class);
        if (!$namespace) {
            throw new InvalidArgumentException($key::class . ' ist nicht registriert.');
        }
        rex_config::set($namespace, 'article.' . $key->value, $articleId);
        unset(self::$cache[$key::class . '::' . $key->value]);
    }

    public static function remove(BackedEnum $key): void
    {
        $namespace = ArticleKeyRegistry::getNamespace($key::class);
        if (!$namespace) {
            return;
        }
        rex_config::remove($namespace, 'article.' . $key->value);
        unset(self::$cache[$key::class . '::' . $key->value]);
    }
}
