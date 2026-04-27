<?php

use Yakamara\Roadie\Article\ArticleKeyRegistry;

$registry = ArticleKeyRegistry::all();

if (!$registry) {
    echo rex_view::info('Keine Artikel-Keys registriert.');
    return;
}

// Unconfigured keys across all registered enums
$unconfigured = 0;
foreach ($registry as $enumClass => $namespace) {
    foreach ($enumClass::cases() as $key) {
        if (!rex_config::get($namespace, 'article.' . $key->value)) {
            ++$unconfigured;
        }
    }
}

if ($unconfigured) {
    echo rex_view::warning(
        1 === $unconfigured
            ? '1 Artikel-Key ist noch nicht konfiguriert.'
            : $unconfigured . ' Artikel-Keys sind noch nicht konfiguriert.',
    );
}

foreach ($registry as $enumClass => $namespace) {
    $form = rex_config_form::factory($namespace);

    foreach ($enumClass::cases() as $key) {
        $configKey = 'article.' . $key->value;

        $field = $form->addLinkmapField($configKey);
        $field->setLabel($key->value);

        $id = (int) rex_config::get($namespace, $configKey, 0);
        $article = $id ? rex_article::get($id) : null;
        $field->setNotice($article
            ? '<i class="rex-icon rex-icon-check text-success"></i> ' . rex_escape($article->getName())
            : '<i class="rex-icon rex-icon-warning text-warning"></i> Nicht konfiguriert',
        );
    }

    $title = 'Artikel-Keys' . (count($registry) > 1 ? ' · ' . $namespace : '');
    echo rex_view::content($form->get(), $title);
}
