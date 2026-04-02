<?php

/** @var rex_addon $this */

$table = rex_sql_table::get(rex::getTable('media'));

foreach (rex_clang::getAll() as $clang) {
    $suffix = $clang->getId() >= 2 ? '_' . $clang->getId() : '';
    $table
        ->removeColumn('med_alt' . $suffix)
        ->removeColumn('med_caption' . $suffix);
}

$table
    ->removeColumn('med_is_decorative')
    ->ensure();
