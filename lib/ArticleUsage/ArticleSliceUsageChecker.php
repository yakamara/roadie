<?php

namespace Yakamara\Roadie\ArticleUsage;

use rex;
use rex_article;
use rex_sql;

class ArticleSliceUsageChecker
{
    /** @return list<string> */
    public static function check(int $articleId): array
    {
        $conditions = [];

        for ($i = 1; $i <= 10; ++$i) {
            $conditions[] = "link$i = $articleId";
        }
        for ($i = 1; $i <= 10; ++$i) {
            $conditions[] = "FIND_IN_SET($articleId, linklist$i)";
        }

        $sql = rex_sql::factory();
        $rows = $sql->getArray(
            'SELECT DISTINCT article_id, clang_id FROM ' . rex::getTable('article_slice')
            . ' WHERE ' . implode(' OR ', $conditions),
        );

        $usages = [];
        foreach ($rows as $row) {
            $article = rex_article::get((int) $row['article_id'], (int) $row['clang_id']);
            $name = $article ? $article->getName() : '#' . $row['article_id'];
            $usages[] = 'Slice in „' . $name . '"';
        }

        return $usages;
    }
}
