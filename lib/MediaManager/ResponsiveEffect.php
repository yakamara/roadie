<?php

use Yakamara\Roadie\Component\Image\ImageResolution;
use Yakamara\Roadie\Component\Image\ImageResolutionValues;

class rex_effect_roadie_responsive extends rex_effect_abstract
{
    public function execute(): void
    {
        if (!rex_get('roadie', 'bool', false)) {
            return;
        }
        //        $file = rex_media_manager::getMediaFile();
        $fileName = $this->media->getMediaFilename();
        $data = self::parseFileName($fileName);
        $this->media->setMediaPath(rex_path::media($data['fileName']));
        $this->media->setFormat($data['extension']);
    }

    /**
     * Returns an array of image data based on the given filename.
     *
     * For example, if you pass `sky@200w.jpg`, you will get:
     *
     * ```php
     * [
     *     'fileName'   => 'sky.jpg',
     *     'extension' => 'jpg',
     *     'width'     => 200,
     *     'format'    => null,
     * ]
     * ```
     *
     * If you pass `sky.jpg@200w.webp`, you will get:
     *
     * ```php
     * [
     *     'fileName'   => 'sky.jpg',
     *     'extension' => 'jpg',
     *     'width'     => 200,
     *     'format'    => 'webp',
     * ]
     * ```
     *
     * @return array{
     *     fileName: string,
     *     format: string,
     *     width: int|null
     * }
     */
    private static function parseFileName(string $fileName): array
    {
        $format = pathinfo($fileName, PATHINFO_EXTENSION);
        $parts = explode('@', rtrim(pathinfo($fileName, PATHINFO_FILENAME), 'w'));
        $extension = pathinfo($parts[0], PATHINFO_EXTENSION);
        if ('' === $extension) {
            $extension = $format;
            $format = null;
        }

        return [
            'fileName' => pathinfo($parts[0], PATHINFO_FILENAME) . '.' . $extension,
            'extension' => $extension,
            'width' => (isset($parts[1]) && in_array((int) $parts[1], ImageResolutionValues::getValue(ImageResolution::All)) ? (int) $parts[1] : null),
            'format' => $format,
        ];
    }

    public function getName(): string
    {
        return rex_i18n::msg('roadie_media_manager_effect_responsive');
    }

    public static function handle(rex_extension_point $ep): void
    {
        if (!rex_get('roadie', 'bool', false)) {
            return;
        }

        $effects = (array) $ep->getSubject();
        $fileName = rex_media_manager::getMediaFile();
        $data = self::parseFileName($fileName);

        if (count($effects) < 1) {
            return;
        }

        foreach ($effects as $index => $effect) {
            if (isset($effect['params']['width'])) {
                if (isset($effect['params']['height']) && (int) $effect['params']['height'] > 0) {
                    $effect['params']['height'] = ceil((int) $effect['params']['height'] * $data['width'] / (int) $effect['params']['width']);
                }
                $effect['params']['width'] = $data['width'];
            }
            if ('image_format' === $effect['effect']) {
                $effect['params']['convert_to'] = $data['format'];
            }
            $effects[$index] = $effect;
        }
        $ep->setSubject($effects);
    }
}
