<?php

namespace Yakamara\Roadie\MediaPool;

use rex_clang;
use rex_media;
use rex_media_manager;

use const PATHINFO_FILENAME;

class Media
{
    private ?rex_media $media;

    protected function __construct(string $fileName)
    {
        $this->media = rex_media::get($fileName);
    }

    public static function get(string $fileName): ?static
    {
        $instance = new self($fileName);
        if ($instance->media) {
            return $instance;
        }

        return null;
    }

    public function getAlt(): string
    {
        return $this->getValue('med_alt');
    }

    public function getCaption(): string
    {
        return $this->getValue('med_caption');
    }

    public function getCopyright(): string
    {
        return $this->getValue('med_copyright');
    }

    public function getTitle(): string
    {
        if (rex_clang::getCurrentId() >= 2) {
            return $this->getValue('med_title');
        }

        return $this->media->getTitle();
    }

    protected function getValue($field): string
    {
        if (rex_clang::getCurrentId() >= 2) {
            $field .= '_' . rex_clang::getCurrentId();
        }

        return $this->media->getValue($field) ?: '';
    }

    public function getDimensions(): array
    {
        return [$this->media->getWidth(), $this->media->getHeight()];
    }

    public function getDimensionsByMediaManagerType(string $mediaManagerType): array
    {
        $media = rex_media_manager::create($mediaManagerType, $this->media->getFileName())->getMedia();

        return [$media->getWidth(), $media->getHeight()];
    }

    public function getFormat(): string
    {
        return $this->media->getType();
    }

    public function getFileNameWithoutExtension(): string
    {
        return pathinfo($this->media->getFileName(), PATHINFO_FILENAME);
    }
}
