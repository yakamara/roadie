<?php

namespace Yakamara\Roadie\Icons;

use rex_file;
use rex_path;

class IconRegistry
{
    /**
     * Ordnername der Default-Library in assets/backend/icons/.
     * Icons aus dieser Library werden ohne library-Attribut gerendert.
     * Kann via setDefaultLibrary() überschrieben werden.
     */
    private static string $defaultLibrary = 'default';
    private static string $iconsDirectory = '';
    private static ?string $metaFile = null;

    /** @var array<string, mixed>|null */
    private static ?array $manifest = null;

    public static function setDefaultLibrary(string $library): void
    {
        self::$defaultLibrary = $library;
    }

    public static function getDefaultLibrary(): string
    {
        return self::$defaultLibrary;
    }

    public static function setIconsDirectory(string $path): void
    {
        self::$iconsDirectory = $path;
    }

    public static function getIconsDirectory(): string
    {
        return self::$iconsDirectory;
    }

    public static function setMetaFile(string $path): void
    {
        self::$metaFile = $path;
    }

    public static function getMetaFile(): ?string
    {
        return self::$metaFile;
    }

    /**
     * Gibt alle Libraries mit ihren Icons zurück.
     *
     * @return array<int, array{name: string, isDefault: bool, icons: array}>
     */
    public static function getLibraries(): array
    {
        return self::loadManifest()['libraries'] ?? [];
    }

    /**
     * Gibt ein einzelnes Icon zurück.
     *
     * @param string|null $library Library-Name, null für Default-Library
     * @param string      $name    Icon-Name
     * @return array{name: string, label: string, keywords: array<string>, svg: string}|null
     */
    public static function get(?string $library, string $name): ?array
    {
        $manifest = self::loadManifest();
        $libraryName = $library ?? $manifest['defaultLibrary'] ?? self::$defaultLibrary;

        foreach ($manifest['libraries'] ?? [] as $lib) {
            if ($lib['name'] !== $libraryName) {
                continue;
            }
            foreach ($lib['icons'] as $icon) {
                if ($icon['name'] === $name) {
                    return $icon;
                }
            }
        }

        return null;
    }

    /**
     * Parst einen gespeicherten Wert (z. B. "my-icons:smile" oder "arrow-right")
     * in ein Array ['library' => ?string, 'name' => string].
     * Bei Werten ohne Prefix (Default-Library) ist library = null.
     *
     * @return array{library: ?string, name: string}
     */
    public static function parseValue(string $value): array
    {
        if (str_contains($value, ':')) {
            [$library, $name] = explode(':', $value, 2);
            return ['library' => $library, 'name' => $name];
        }

        return ['library' => null, 'name' => $value];
    }

    /**
     * Erzeugt den gespeicherten Wert aus Library + Name.
     * library=null → nur Name, sonst → "library:name".
     */
    public static function buildValue(?string $library, string $name): string
    {
        $manifest = self::loadManifest();
        $defaultLibrary = $manifest['defaultLibrary'] ?? self::$defaultLibrary;

        if (null === $library || $library === $defaultLibrary) {
            return $name;
        }

        return $library . ':' . $name;
    }

    /**
     * Gibt den bereinigten SVG-Markup für ein Icon zurück (Backend-Vorschau).
     * Akzeptiert den gespeicherten Wert (z. B. "my-icons:smile" oder "arrow-right").
     *
     * @return string SVG-HTML-String oder leerer String
     */
    public static function renderPreview(string $value): string
    {
        if ('' === $value) {
            return '';
        }

        $parsed = self::parseValue($value);
        $icon = self::get($parsed['library'], $parsed['name']);

        if (null === $icon) {
            return '';
        }

        return str_replace('<svg', '<svg class="iconpicker-svg"', $icon['svg']);
    }

    // ── Private ───────────────────────────────────────────────────────────────

    /** @return array<string, mixed> */
    private static function loadManifest(): array
    {
        if (null !== self::$manifest) {
            return self::$manifest;
        }

        $path = rex_path::addonData('roadie', 'icons.json');
        $json = rex_file::get($path);

        if (null === $json) {
            self::$manifest = [];
            return self::$manifest;
        }

        self::$manifest = json_decode($json, true) ?? [];
        return self::$manifest;
    }
}
