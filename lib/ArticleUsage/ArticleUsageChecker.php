<?php

namespace Yakamara\Roadie\ArticleUsage;

use rex_api_exception;
use rex_category;
use rex_extension_point;

/**
 * Prüft vor dem Löschen eines Artikels ob dieser noch referenziert wird.
 *
 * Eingebaute Checker (werden in roadie/boot.php registriert):
 *   - SliceUsageChecker  — link1–link10 und linklist1–linklist10 in rex_article_slice
 *   - MetaInfoUsageChecker — REX_LINK_WIDGET und REX_LINKLIST_WIDGET MetaInfo-Felder
 *
 * Zusätzliche Checker aus dem project-Addon registrieren:
 *   ArticleUsageChecker::addChecker(function(int $articleId): array {
 *       // Gibt eine Liste lesbarer Fundstellen zurück, z. B.:
 *       return ['Artikel-Key „contact"'];
 *   });
 */
class ArticleUsageChecker
{
    /** @var list<callable(int): list<string>> */
    private static array $checkers = [];

    public static function addChecker(callable $checker): void
    {
        self::$checkers[] = $checker;
    }

    /** @return list<string> */
    public static function check(int $articleId): array
    {
        $usages = [];
        foreach (self::$checkers as $checker) {
            array_push($usages, ...($checker)($articleId));
        }
        return $usages;
    }

    public static function handlePreDelete(rex_extension_point $ep): void
    {
        $usages = self::check((int) $ep->getParam('id'));
        if ($usages) {
            throw new rex_api_exception(
                'Der Artikel wird noch verwendet und kann nicht gelöscht werden:'
                . '<ul><li>' . implode('</li><li>', array_map('rex_escape', $usages)) . '</li></ul>',
            );
        }
    }

    /**
     * Prüft eine Kategorie und alle enthaltenen Artikel/Unterkategorien rekursiv.
     *
     * @return list<string>
     */
    public static function checkCategory(rex_category $category): array
    {
        $usages = [];

        foreach ($category->getArticles(true) as $article) {
            foreach (self::check($article->getId()) as $usage) {
                $usages[] = '„' . $article->getName() . '": ' . $usage;
            }
        }

        foreach ($category->getChildren(true) as $child) {
            array_push($usages, ...self::checkCategory($child));
        }

        return $usages;
    }
}
