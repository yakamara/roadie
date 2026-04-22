<?php

namespace Yakamara\Roadie\Slice;

use rex;
use rex_article_slice;
use rex_string;

use const PREG_SET_ORDER;

class SliceManager
{
    // Regulärer Ausdruck, der alle Überschriften erfasst
    // (?<tagName>h[1-6]) speichert den Tagnamen (h1-h6) in der Gruppe "tagName"
    // (?<attributes>[ \t\r\n][^>]*)? speichert optionale Attribute in der Gruppe "attributes"
    // (?<content>.*?) speichert den Inhalt in der Gruppe "content"
    private const string HEADING_PATTERN = '/<(?<tagName>h[1-6])(?<attributes>[ \t\r\n][^>]*)?>((?<content>.*?)<\/h[1-6]>)/is';

    private static string $propertySliceDepth = 'roadie_slice_depth';

    private static string $propertyH1Key = 'roadie_has_h1';

    private static ?SliceManager $instance = null;

    private bool $hasH1 = false;
    private int $currentDepth = 0;

    // Singleton-Pattern
    public static function getInstance(): ?self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Initialisierung
    public function init(): static
    {
        // Status aus rex::getProperty holen oder neu setzen
        $this->currentDepth = rex::getProperty(self::$propertySliceDepth, 0);
        $this->hasH1 = rex::getProperty(self::$propertyH1Key, false);

        return $this;
    }

    // Speichert den aktuellen Status in rex::setProperty
    public function persistState(): static
    {
        rex::setProperty(self::$propertySliceDepth, $this->currentDepth);
        rex::setProperty(self::$propertyH1Key, $this->hasH1);

        return $this;
    }

    // Setzt den Typ des aktuellen Abschnitts
    public function setCurrentSliceType(rex_article_slice $slice, SliceType $type): static
    {
        // Tiefe anpassen basierend auf Abschnittstyp
        if (!$this->hasH1) {
            $this->currentDepth = 1;
            $this->hasH1 = true;
        } elseif (SliceType::NEW_SECTION === $type) {
            $this->currentDepth = 2;
        } elseif (SliceType::SUB_SECTION === $type) {
            ++$this->currentDepth;
        } elseif (1 === $this->currentDepth && SliceType::CONTINUATION === $type) {
            // Sonderfall, wenn der Slice fortgesetzt wird aber sich direkt nach einer h1 befindet
            ++$this->currentDepth;
        }
        // Bei SliceType::CONTINUATION bleibt die Tiefe ansonsten gleich

        if ($slice->isOnline()) {
            $this->persistState();
        }
        return $this;
    }

    // Gibt den HTML-Tag für die aktuelle Überschriftenebene zurück
    public function getHeadingTag(): string
    {
        $level = min(6, max(1, $this->currentDepth)); // h1-h6 sicherstellen
        return 'h' . $level;
    }

    // Gibt das HTML für eine Überschrift zurück
    public function renderHeading($heading, array $attributes = []): string
    {
        $tag = $this->getHeadingTag();
        return '<' . $tag . rex_string::buildAttributes($attributes) . '>' . $heading . '</' . $tag . '>';
    }

    /**
     * Verarbeitet Html-Inhalte (WYSIWYG) und passt Überschriften an die aktuelle Hierarchie an.
     *
     * @param string $html Der HTML-Inhalt aus dem WYSIWYG-Editor
     * @param int $baseOffset Offset für die Überschriftenebenen (0 = keine Änderung)
     * @return string Der angepasste HTML-Inhalt
     */
    public function processHtml(string $html, int $baseOffset = 0): string
    {
        $html = $this->cleanHtml($html);

        // Basislevel bestimmen (h1 bleibt, falls keine vorhanden)
        $baseLevel = max(1, $this->currentDepth + $baseOffset);
        $lastLevel = $baseLevel;

        // 1. Schritt: Alle vorkommenden Überschriften erfassen
        preg_match_all(self::HEADING_PATTERN, $html, $matches, PREG_SET_ORDER);

        // Keine Überschriften gefunden
        if (empty($matches)) {
            return $html;
        }

        // Kleinste verwendete Überschrift bestimmen
        $minLevel = 6; // Startwert hoch setzen
        foreach ($matches as $match) {
            $level = (int) substr($match['tagName'], 1, 1);
            if (2 !== $level) { // h2 bleibt immer h2
                $minLevel = min($minLevel, $level);
            }
        }

        // Falls keine h1 existiert, wird die kleinste gefundene Überschrift auf h3 gesetzt
        $levelAdjustment = 3 - ($this->hasH1 ? max(2, $minLevel) : $minLevel);

        // 2. Schritt: Ersetzen mit den neuen Levels
        return preg_replace_callback(self::HEADING_PATTERN, static function ($match) use ($levelAdjustment, &$lastLevel) {
            $originalLevel = (int) substr($match['tagName'], 1, 1);

            // Falls eine h1 existiert, wird sie zur h2, ansonsten bleibt h2 als h2 erhalten
            $newLevel = 1 === $originalLevel ? 2 : (2 === $originalLevel ? 2 : max(3, min(6, $originalLevel + $levelAdjustment)));

            // Verhindert Lücken zwischen den Überschriften
            if ($newLevel > $lastLevel + 1) {
                $newLevel = $lastLevel + 1;
            }

            // Aktualisiere die letzte verwendete Stufe
            $lastLevel = $newLevel;

            $attributes = $match['attributes'] ?? '';
            return "<h{$newLevel}{$attributes}>{$match['content']}</h{$newLevel}>";
        }, $html);
    }

    public function cleanHtml(string $html): string
    {
        return preg_replace('@<p>(<strong>)?(<br\s?\/?>)?(<\/strong>)?<\/p>@', '', $html);
    }

    // Erhöht die Tiefe um eine Ebene (z.B. nach einer Modul-Überschrift)
    public function descendDepth(rex_article_slice $slice): static
    {
        ++$this->currentDepth;
        if ($slice->isOnline()) {
            $this->persistState();
        }
        return $this;
    }

    // Gibt die aktuelle Abschnittstiefe zurück
    public function getCurrentDepth(): int
    {
        return $this->currentDepth;
    }

    public function hasH1(): bool
    {
        return $this->hasH1;
    }
}
