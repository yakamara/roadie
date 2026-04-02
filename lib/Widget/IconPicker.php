<?php

namespace Yakamara\Roadie\Widget;

use Yakamara\Roadie\Icons\IconRegistry;

use function rex_escape;

class IconPicker
{
    private static bool $modalRendered = false;

    /**
     * Renders the inline picker field for use in REDAXO module inputs.
     * The shared modal is automatically appended on the first call.
     *
     * Usage:
     *   echo IconPicker::widget('REX_INPUT_VALUE[1]', 'REX_VALUE[1]');
     *
     * @param string $name         The name attribute for the hidden input
     * @param string $currentValue Currently selected value (e.g. "arrow-right" or "my-icons:smile")
     */
    public static function widget(string $name, string $currentValue = ''): string
    {
        $escapedName  = rex_escape($name, 'html_attr');
        $escapedValue = rex_escape($currentValue, 'html_attr');

        $previewSvg   = $currentValue ? IconRegistry::renderPreview($currentValue) : '';
        $previewLabel = $currentValue
            ? rex_escape(IconRegistry::parseValue($currentValue)['name'])
            : 'Kein Icon gewählt';
        $clearHidden  = $currentValue ? '' : ' hidden';

        $html =
            '<div class="iconpicker">
                <input type="hidden" name="' . $escapedName . '" value="' . $escapedValue . '">
                <div class="iconpicker-current">
                    <span class="iconpicker-current-svg">' . $previewSvg . '</span>
                    <span class="iconpicker-current-label">' . $previewLabel . '</span>
                </div>
                <button type="button" class="btn btn-default iconpicker-open">Icon wählen</button>
                <button type="button" class="btn btn-default iconpicker-clear"' . $clearHidden . ' title="Auswahl löschen">&#x2715;</button>
            </div>';

        if (!self::$modalRendered) {
            $html .= self::modal();
        }

        return $html;
    }

    /**
     * Renders the shared modal (once per page, shared by all picker instances).
     * Called automatically by the first widget() call; can also be called explicitly.
     */
    public static function modal(): string
    {
        self::$modalRendered = true;

        $librariesHtml = '';

        foreach (IconRegistry::getLibraries() as $library) {
            $libraryName  = $library['name'];
            $isDefault    = $library['isDefault'];
            $libraryLabel = rex_escape($isDefault ? 'Standard' : $libraryName);

            $itemsHtml = '';
            foreach ($library['icons'] as $icon) {
                $iconName     = $icon['name'];
                $iconLabel    = rex_escape($icon['label']);
                $iconKeywords = rex_escape(implode(' ', array_merge([$icon['label']], $icon['keywords'])), 'html_attr');
                $value        = IconRegistry::buildValue($isDefault ? null : $libraryName, $iconName);
                $escapedValue = rex_escape($value, 'html_attr');
                $escapedName  = rex_escape($iconName, 'html_attr');
                $svgWithClass = str_replace('<svg', '<svg class="iconpicker-svg"', $icon['svg']);

                $itemsHtml .= '<button type="button"'
                    . ' class="iconpicker-item"'
                    . ' data-library="' . rex_escape($libraryName, 'html_attr') . '"'
                    . ' data-icon="' . $escapedName . '"'
                    . ' data-value="' . $escapedValue . '"'
                    . ' data-keywords="' . $iconKeywords . '"'
                    . ' title="' . $iconLabel . '"'
                    . '>' . $svgWithClass . '</button>';
            }

            $librariesHtml .= '<div class="iconpicker-library" data-library="' . rex_escape($libraryName, 'html_attr') . '">'
                . '<h5>' . $libraryLabel . '</h5>'
                . '<div class="iconpicker-items">' . $itemsHtml . '</div>'
                . '</div>';
        }

        return <<<HTML
        <div class="iconpicker-modal" hidden>
            <div class="iconpicker-modal-backdrop"></div>
            <div class="iconpicker-modal-dialog">
                <div class="iconpicker-modal-header">
                    <h4 class="iconpicker-modal-title">Icon auswählen</h4>
                    <button type="button" class="iconpicker-modal-close" aria-label="Schließen">&#x2715;</button>
                </div>
                <div class="iconpicker-modal-body">
                    <div class="iconpicker-search">
                        <input type="search" class="form-control" placeholder="Icons suchen …" autocomplete="off">
                    </div>
                    <div class="iconpicker-libraries">
                        {$librariesHtml}
                    </div>
                </div>
                <div class="iconpicker-modal-footer">
                    <button type="button" class="btn btn-default iconpicker-modal-cancel">Abbrechen</button>
                </div>
            </div>
        </div>
        HTML;
    }
}
