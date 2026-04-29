<?php

namespace Yakamara\Roadie\MediaPool;

use rex;
use rex_clang;
use rex_extension_point;
use rex_file;
use rex_media;
use rex_sql;

use function count;

class MediaExtension
{
    public static function extendForm(rex_extension_point $ep): string
    {
        /** @var rex_sql|rex_media|null $media */
        $media = $ep->getParam('media');
        $clangs = rex_clang::getAll();
        $isDecorative = $media !== null && (bool) $media->getValue('med_is_decorative');

        $missingAlt = !$isDecorative && $media !== null && self::hasMissingAlt($media, $clangs);

        $html = '
            <wa-switch name="med_is_decorative" value="1"' . ($isDecorative ? ' checked' : '') . '>
                Schmuckgrafik – kein Alternativtext erforderlich
            </wa-switch>
            <wa-callout id="roadie-alt-hint" variant="warning"' . ($missingAlt ? '' : ' hidden') . '>
                Kein Alternativtext hinterlegt. Bitte ergänzen oder als Schmuckgrafik markieren.
            </wa-callout>
            ';

        if (count($clangs) > 1) {
            $tabItems = [];
            $tabPanels = [];
            foreach ($clangs as $clang) {
                $suffix = $clang->getId() >= 2 ? '_' . $clang->getId() : '';
                $tabId = 'roadie-media-lang-' . $clang->getId();
                $tabItems[] = '<wa-tab panel="' . $tabId . '">' . rex_escape($clang->getName()) . '</wa-tab>';
                $tabPanels[] = '
                    <wa-tab-panel name="' . $tabId . '">
                        <div class="wa-stack">
                            <wa-input label="Alternativtext" name="med_alt' . $suffix . '" value="' . rex_escape((string) ($media?->getValue('med_alt' . $suffix) ?: '')) . '"></wa-input>
                            <wa-textarea label="Bildunterschrift" name="med_caption' . $suffix . '" value="' . rex_escape((string) ($media?->getValue('med_caption' . $suffix) ?: '')) . '"></wa-textarea>
                        </div>
                    </wa-tab-panel>';
            }
            $html .= '<wa-tab-group>' . implode('', $tabItems) . ' ' . implode('', $tabPanels) . '</wa-tab-group>';
        } else {
            $clang = current($clangs);
            $suffix = $clang->getId() >= 2 ? '_' . $clang->getId() : '';

            $html .=
                '<div class="wa-stack">
                    <wa-input label="Alternativtext" name="med_alt' . $suffix . '" value="' . rex_escape((string) ($media?->getValue('med_alt' . $suffix) ?: '')) . '"></wa-input>
                    <wa-textarea label="Bildunterschrift" name="med_caption' . $suffix . '" value="' . rex_escape((string) ($media?->getValue('med_caption' . $suffix) ?: '')) . '"></wa-textarea>
                </div>';
        }

        //        $html .= '</fieldset>';

        $html =
            '<dl class="rex-form-group form-group">
                <dt><label>Alternativtext &amp; Bildunterschrift</label></dt>
                <dd style="padding-block-start: var(--wa-space-m)">
                    <div class="wa-stack">' . $html . '</div>
                </dd>
            </dl>
            <dl class="rex-form-group form-group">
                <dt><label>Copyright</label></dt>
                <dd>
                    <div class="wa-stack">
                        <wa-input name="med_copyright" value="' . rex_escape((string) ($media?->getValue('med_copyright') ?: '')) . '"></wa-input>
                    </div>
                </dd>
            </dl>
            <script>
            (() => {
                const hint = document.getElementById("roadie-alt-hint");
                if (!hint) return;
                const form = hint.closest("form");
                if (!form) return;

                function updateHint() {
                    const decorative = !!form.querySelector("[name=med_is_decorative]")?.checked;
                    const hasAlt = [...form.querySelectorAll("[name^=med_alt]")].some(el => el.value.trim() !== "");
                    hint.hidden = decorative || hasAlt;
                }

                form.querySelector("[name=med_is_decorative]")?.addEventListener("change", updateHint);
                form.querySelectorAll("[name^=med_alt]").forEach(el => el.addEventListener("input", updateHint));
            })();
            </script>';

        return $ep->getSubject() . $html;
    }

    private static function hasMissingAlt(rex_sql|rex_media $media, array $clangs): bool
    {
        foreach ($clangs as $clang) {
            $suffix = $clang->getId() >= 2 ? '_' . $clang->getId() : '';
            if ('' === trim((string) ($media->getValue('med_alt' . $suffix) ?: ''))) {
                return true;
            }
        }
        return false;
    }

    public static function extendListThumbnail(rex_extension_point $ep): string
    {
        /** @var rex_media $media */
        $media = $ep->getParam('media');

        if (!rex_media::isImageType(rex_file::extension($media->getFileName()))) {
            return $ep->getSubject();
        }

        if ((bool) $media->getValue('med_is_decorative')) {
            return $ep->getSubject();
        }

        if (!self::hasMissingAlt($media, rex_clang::getAll())) {
            return $ep->getSubject();
        }

        return
            '<span style="position:relative;display:inline-block">
                ' . $ep->getSubject() . '
                <wa-badge variant="warning" style="position:absolute;top:2px;right:2px" title="Kein Alternativtext">Alt</wa-badge>
            </span>';
    }

    public static function saveOnUpdate(rex_extension_point $ep): void
    {
        $filename = $ep->getParam('filename');
        if (!$filename) {
            return;
        }

        $sql = rex_sql::factory();
        $sql->setTable(rex::getTable('media'));
        $sql->setWhere(['filename' => $filename]);

        foreach (rex_clang::getAll() as $clang) {
            $suffix = $clang->getId() >= 2 ? '_' . $clang->getId() : '';
            $sql->setValue('med_alt' . $suffix, rex_post('med_alt' . $suffix, 'string', ''));
            $sql->setValue('med_caption' . $suffix, rex_post('med_caption' . $suffix, 'string', ''));
        }

        $sql->setValue('med_is_decorative', rex_post('med_is_decorative', 'int', 0));
        $sql->setValue('med_copyright', rex_post('med_copyright', 'string', ''));
        $sql->update();
    }
}
