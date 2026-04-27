<?php

namespace Yakamara\Roadie\ArticleUsage;

use rex;
use rex_addon;
use rex_metainfo_default_type;
use rex_sql;

class MetaInfoUsageChecker
{
    /** @return list<string> */
    public static function check(int $articleId): array
    {
        if (!rex_addon::get('metainfo')->isAvailable()) {
            return [];
        }

        $linkTypeId = rex_metainfo_default_type::REX_LINK_WIDGET;
        $linklistTypeId = rex_metainfo_default_type::REX_LINKLIST_WIDGET;

        $sql = rex_sql::factory();
        $fields = $sql->getArray(
            'SELECT name, type_id FROM ' . rex::getTable('metainfo_field')
            . ' WHERE type_id IN (?, ?)',
            [$linkTypeId, $linklistTypeId],
        );

        if (!$fields) {
            return [];
        }

        $usages = [];

        foreach ($fields as $field) {
            $column = $field['name'];
            $isList = (int) $field['type_id'] === $linklistTypeId;
            $table = rex::getTable('article');

            if ($isList) {
                $row = $sql->getArray(
                    "SELECT id, name FROM $table WHERE FIND_IN_SET(?, `$column`) LIMIT 1",
                    [$articleId],
                );
            } else {
                $row = $sql->getArray(
                    "SELECT id, name FROM $table WHERE `$column` = ? LIMIT 1",
                    [$articleId],
                );
            }

            foreach ($row as $r) {
                $usages[] = 'MetaInfo-Feld „' . $column . '" an „' . $r['name'] . '"';
            }
        }

        return $usages;
    }
}
