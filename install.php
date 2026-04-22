<?php

/** @var rex_addon $this */

$table = rex_sql_table::get(rex::getTable('media'));

foreach (rex_clang::getAll() as $clang) {
    $suffix = $clang->getId() >= 2 ? '_' . $clang->getId() : '';
    $table
        ->ensureColumn(new rex_sql_column('med_alt' . $suffix, 'text', true))
        ->ensureColumn(new rex_sql_column('med_caption' . $suffix, 'text', true));
}

$table
    ->ensureColumn(new rex_sql_column('med_is_decorative', 'tinyint(1)', false, '0'))
    ->ensureColumn(new rex_sql_column('med_copyright', 'text', true))
    ->ensure();
