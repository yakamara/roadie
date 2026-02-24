<?php

namespace Yakamara\Roadie\Asset;

use InvalidArgumentException;
use rex;
use rex_file;
use rex_path;

use const PATHINFO_EXTENSION;

final class Asset
{
    public static function url(string $fileName): string
    {
        return self::resolver()->getAssetUrl($fileName);
    }

    public static function scriptTags(string $entrypoint, ?string $directory = null): string
    {
        $scriptTags = [];
        $assets = self::resolver($directory)->getEntrypointFiles($entrypoint);
        foreach ($assets['js'] as $jsFile) {
            $scriptTags[] = '<script src="' . rex_escape($jsFile) . '" defer></script>';
        }
        return implode("\n", $scriptTags);
    }

    public static function linkTags(string $entrypoint, ?string $directory = null): string
    {
        $linkTags = [];
        $assets = self::resolver($directory)->getEntrypointFiles($entrypoint);
        foreach ($assets['css'] as $cssFile) {
            $linkTags[] = '<link rel="stylesheet" href="' . rex_escape($cssFile) . '">';
        }
        return implode("\n", $linkTags);
    }

    public static function preloadFont(string $fileName): string
    {
        $url = self::resolver()->getAssetUrl($fileName);
        $ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));
        return '<link rel="preload" href="' . rex_escape($url) . '" as="font" type="font/' . $ext . '" crossorigin="anonymous">';
    }

    /*
     * Bedeutungsvolles SVG (z. B. Logo)
     * Asset::svgInline('images/logo.svg', 'Firmenname')
     * → <svg class="icon" role="img" aria-label="Firmenname" focusable="false" ...>
     *
     * // Dekoratives SVG
     * Asset::svgInline('images/decoration.svg')
     * → <svg class="icon" aria-hidden="true" focusable="false" ...>
     *
     * Abweichende CSS-Klasse
     * Asset::svgInline('images/hero.svg', 'Hero Illustration', 'hero-image')
     * → <svg class="hero-image" role="img" aria-label="Hero Illustration" focusable="false" ...>
     */
    public static function svgInline(string $fileName, ?string $label = null, string $class = 'icon'): string
    {
        $path = rex_path::frontend(ltrim(self::url($fileName), '/'));
        $content = rex_file::get($path);

        if (false === $content) {
            if (rex::isDebugMode()) {
                throw new InvalidArgumentException("SVG file not found: $path");
            }
            return '';
        }

        $a11yAttrs = null !== $label
            ? 'role="img" aria-label="' . rex_escape($label) . '"'
            : 'aria-hidden="true"';

        return (string) preg_replace_callback(
            '/<svg\b([^>]*)>/i',
            static function (array $matches) use ($class, $a11yAttrs): string {
                $existingAttrs = $matches[1];

                // Bestehende class-Werte extrahieren und entfernen
                $existingClass = '';
                $existingAttrs = (string) preg_replace_callback(
                    '/\s*\bclass="([^"]*)"/i',
                    static function (array $m) use (&$existingClass): string {
                        $existingClass = $m[1];
                        return '';
                    },
                    $existingAttrs,
                );

                // Überschriebene a11y-Attribute entfernen
                $existingAttrs = (string) preg_replace(
                    '/\s*\b(aria-hidden|role|aria-label|focusable)="[^"]*"/i',
                    '',
                    $existingAttrs,
                );

                $mergedClass = trim(($existingClass ? $existingClass . ' ' : '') . $class);

                return '<svg class="' . rex_escape($mergedClass) . '" ' . $a11yAttrs . ' focusable="false"' . $existingAttrs . '>';
            },
            $content,
            1,
        );
    }

    public static function svgSymbol(string $symbolId, ?string $label = null): string
    {
        $cleanId = ltrim(str_replace(['.svg', 'icon-'], '', $symbolId), '/');

        $svgAttrs = null !== $label
            ? 'role="img" aria-label="' . rex_escape($label) . '"'
            : 'aria-hidden="true"';

        return '<svg class="icon" ' . $svgAttrs . ' focusable="false"><use href="#svg-' . rex_escape($cleanId) . '"></use></svg>';
    }

    private static function resolver(?string $directory = null): AssetResolver
    {
        static $instances = [];
        return $instances[$directory ?? ''] ??= new AssetResolver($directory);
    }
}
