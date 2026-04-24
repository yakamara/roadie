<?php

namespace Yakamara\Roadie\ArticleUsage;

use Yakamara\Roadie\Article\ArticleKeyRegistry;

class ArticleKeyUsageChecker
{
    /** @return list<string> */
    public static function check(int $articleId): array
    {
        $usages = [];

        foreach (ArticleKeyRegistry::all() as $enumClass => $namespace) {
            foreach ($enumClass::cases() as $case) {
                $id = (int) \rex_config::get($namespace, 'article.' . $case->value);
                if ($id === $articleId) {
                    $usages[] = 'Artikel-Key „' . $case->value . '"';
                }
            }
        }

        return $usages;
    }
}
