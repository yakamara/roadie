<?php

namespace Yakamara\Roadie\Section;

use rex;

class SectionManager
{
    private const string PROPERTY_KEY = 'roadie_section_variant';

    private static ?self $instance = null;

    private static array $availableVariants = [];

    private SectionVariant $currentVariant = SectionVariant::Plain;

    public static function getInstance(): static
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function init(): static
    {
        $value = rex::getProperty(self::PROPERTY_KEY);
        $this->currentVariant = $value instanceof SectionVariant
            ? $value
            : SectionVariant::Plain;

        return $this;
    }

    public function setCurrentVariant(SectionVariant $appearance): static
    {
        $this->currentVariant = $appearance;
        rex::setProperty(self::PROPERTY_KEY, $appearance);

        return $this;
    }

    public function getCurrentVariant(): SectionVariant
    {
        return $this->currentVariant;
    }

    public static function registerVariants(SectionVariant ...$appearances): void
    {
        self::$availableVariants = $appearances;
    }

    public static function getAvailableVariants(): array
    {
        return self::$availableVariants ?: SectionVariant::cases();
    }

    public function is(SectionVariant $appearance): bool
    {
        return $this->currentVariant === $appearance;
    }
}
