<?php

namespace Yakamara\Roadie\Widget;

use rex_escape;

class ColorPicker
{
    /** @var array<string, array{label: string, colors: array<string, array{color: string, name: string}>}> */
    private static array $groups = [];

    // ── Statische API ──────────────────────────────────────────────────────────

    /**
     * Registriert eine Farbgruppe.
     *
     * @param array<string, array{color: string, name: string}> $colors
     */
    public static function registerGroup(string $groupKey, string $label, array $colors): void
    {
        self::$groups[$groupKey] = ['label' => $label, 'colors' => $colors];
    }

    /**
     * @return array<string, array{label: string, colors: array}>
     */
    public static function getGroups(): array
    {
        return self::$groups;
    }

    /**
     * Prüft einen Key gegen registrierte Farben.
     * Gibt den Key zurück wenn gültig, sonst leeren String.
     */
    public static function validate(string $key): string
    {
        if ('' === $key) {
            return '';
        }
        if ('transparent' === $key) {
            return 'transparent';
        }
        foreach (self::$groups as $group) {
            if (array_key_exists($key, $group['colors'])) {
                return $key;
            }
        }
        return '';
    }

    // ── Widget ─────────────────────────────────────────────────────────────────

    /**
     * Renders the color picker field for use in REDAXO module inputs.
     *
     * Usage:
     *   echo ColorPicker::widget('REX_INPUT_VALUE[2]', 'REX_VALUE[2]');
     *
     * @param string $name         The name attribute for the hidden input
     * @param string $currentValue Currently selected color key (e.g. "primary", "transparent")
     */
    public static function widget(string $name, string $currentValue = ''): string
    {
        $value = self::validate($currentValue);

        $html = '<div class="colorpicker">';
        $html .= '<input type="hidden" name="' . rex_escape($name, 'html_attr') . '" value="' . rex_escape($value, 'html_attr') . '">';

        // Transparent-Swatch (vor allen Gruppen)
        $html .= '<div class="colorpicker-swatches">';
        $html .= self::renderSwatch('transparent', 'Transparent', null, $value);
        $html .= '</div>';

        // Farbgruppen
        foreach (self::$groups as $group) {
            $html .= '<div class="colorpicker-group" role="group" aria-label="' . rex_escape($group['label'], 'html_attr') . '">';
            $html .= '<div class="colorpicker-group-label">' . rex_escape($group['label']) . '</div>';
            $html .= '<div class="colorpicker-swatches">';

            foreach ($group['colors'] as $colorKey => $colorDef) {
                $html .= self::renderSwatch($colorKey, $colorDef['name'], $colorDef['color'], $value);
            }

            $html .= '</div>';
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    private static function renderSwatch(string $key, string $name, ?string $color, string $currentValue): string
    {
        $escapedName = rex_escape($name, 'html_attr');
        $pressed     = $currentValue === $key ? 'true' : 'false';
        $class       = 'colorpicker-swatch' . ('transparent' === $key ? ' colorpicker-swatch--transparent' : '');
        $style       = $color !== null ? ' style="--swatch-color: ' . rex_escape($color, 'html_attr') . '"' : '';

        return '<button type="button"'
            . ' class="' . $class . '"'
            . ' data-value="' . rex_escape($key, 'html_attr') . '"'
            . ' aria-pressed="' . $pressed . '"'
            . ' aria-label="' . $escapedName . '"'
            . ' title="' . $escapedName . '"'
            . $style
            . '></button>';
    }
}
