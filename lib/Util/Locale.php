<?php

namespace Yakamara\Roadie\Util;

use http\Exception\InvalidArgumentException;
use rex_clang;

class Locale
{
    public static function setDefault(): void
    {
        $clang = rex_clang::getCurrent();

        if (null === $clang->getValue('locale')) {
            throw new InvalidArgumentException('MetaInfo field "clang_locale" not found!');
        }

        if (!is_string($clang->getValue('locale')) || '' === $clang->getValue('locale')) {
            throw new InvalidArgumentException('MetaInfo field "clang_locale" is not a string or is empty! Example: de_DE');
        }

        if (null === $clang->getValue('setlocale')) {
            throw new InvalidArgumentException('MetaInfo field "clang_setlocale" not found!');
        }

        if (!is_string($clang->getValue('setlocale')) || '' === $clang->getValue('setlocale')) {
            throw new InvalidArgumentException('MetaInfo field "clang_setlocale" is not a string or is empty! Example: de_DE,de_DE@euro. Without utf-8 suffix.');
        }

        [$language, $country] = explode('_', $clang->getValue('locale'), 2);

        \Locale::setDefault(strtolower($language) . '-' . strtoupper($country));

        $locales = [];
        foreach (explode(',', trim($clang->getValue('setlocale'))) as $locale) {
            $locales[] = $locale . '.UTF-8';
            $locales[] = $locale . '.UTF8';
            $locales[] = $locale . '.utf-8';
            $locales[] = $locale . '.utf8';
            $locales[] = $locale;
        }

        setlocale(LC_ALL, $locales);
    }
}
