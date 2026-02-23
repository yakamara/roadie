<?php

namespace Yakamara\Roadie\Component\Image;

use InvalidArgumentException;
use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\MediaPool\Media;
use Yakamara\Roadie\Util\FileTypeDetector;
use rex_url;

use function count;
use function in_array;
use function is_array;
use function is_string;
use function sprintf;

use const PATHINFO_EXTENSION;
use const PATHINFO_FILENAME;

final class Image extends Component
{
    protected ?Media $media;
    protected ?FileTypeDetector $fileTypeDetector;
    protected ?string $fileMimeType;

    public array $sources = [];

    public function __construct(
        public string $imageName,

        public string $mediaManagerType,

        public array|ImageResolution $resolutions = [],

        /** @var array<ImageMotif> $motifs */
        public array $motifs = [],

        /** @var array<ImageFormat> $formats */
        public array $formats = [],

        public ?string $sizes = null,

        public bool $figure = false,

        public bool|string $caption = false,

        public bool|string $copyright = false,

        /**
         * @ToDo lowQualityPlaceholder umsetzen
         */
        // public ?ImageLowQualityPlaceholder $lowQualityPlaceholder = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),

        public HtmlAttributes $imageAttributes = new HtmlAttributes(),
    ) {
        $this->media = Media::get($this->imageName);
        $this->fileTypeDetector = new FileTypeDetector($this->imageName);
        $this->fileMimeType = $this->fileTypeDetector->getMimeType();

        // Check if the format of the passed image is available.
        $availableFormats = ImageFormat::arrayByValues();
        if (!isset($availableFormats[$this->fileMimeType])) {
            throw new InvalidArgumentException('Invalid format by the given image name.');
        }

        // If the format of the image has not yet been explicitly passed, then add it.
        if (!in_array($this->fileMimeType, array_column($this->formats, 'value'))) {
            $this->formats[] = ImageFormat::from($this->fileMimeType);
        }
    }

    /**
     * Returns a `srcset` attribute value based on the given widths or x-descriptors.
     *
     * For example, if you pass `['100w', '200w']`, you will get:
     *
     * ```
     * image-url@100w.ext 100w,
     * image-url@200w.ext 200w
     * ```
     *
     * If you pass x-descriptors, it will be assumed that the image’s current width is the `1x` width.
     * So if you pass `['1x', '2x']` on an image with a 100px-wide transform applied, you will get:
     *
     * ```
     * image-url@100w.ext,
     * image-url@200w.ext 2x
     * ```
     *
     * @param array<string> $sizes
     * @throws InvalidArgumentException
     * @return array|false The `srcset` attribute value, or `false` if it can’t be determined
     */
    protected function getSrcset(string $imageName, array $sizes, string $mediaManagerType): array|false
    {
        $urls = $this->getUrlsBySize($imageName, $sizes, $mediaManagerType);

        if (empty($urls)) {
            return false;
        }

        $srcset = [];

        foreach ($urls as $size => $url) {
            if ('1x' === $size) {
                $srcset[] = $url;
            } else {
                $srcset[] = "$url $size";
            }
        }

        return $srcset;
    }

    /**
     * Returns an array of image transform URLs based on the given widths or x-descriptors.
     *
     * For example, if you pass `['100w', '200w']`, you will get:
     *
     * ```php
     * [
     *     '100w' => 'image-url@100w.ext',
     *     '200w' => 'image-url@200w.ext'
     * ]
     * ```
     *
     * If you pass x-descriptors, it will be assumed that the image’s current width is the indented 1x width.
     * So if you pass `['1x', '2x']` on an image with a 100px-wide transform applied, you will get:
     *
     * ```php
     * [
     *     '1x' => 'image-url@100w.ext',
     *     '2x' => 'image-url@200w.ext'
     * ]
     * ```
     *
     * @param array<string> $sizes
     */
    protected function getUrlsBySize(string $imageName, array $sizes, string $mediaManagerType): array
    {
        if (!$this->fileTypeDetector->isRasterImage()) {
            return [];
        }

        $urls = [];

        [$currentWidth, $currentHeight] = $this->media->getDimensionsByMediaManagerType($mediaManagerType);

        if (!$currentWidth || !$currentHeight) {
            return [];
        }

        foreach ($sizes as $size) {
            if ('1x' === $size) {
                $urls[$size] = $this->getUrl($imageName, $currentWidth, $mediaManagerType);
                continue;
            }

            [$value, $unit] = $this->parseSrcsetSize($size);

            if ('w' === $unit) {
                $width = (int) $value;
            } else {
                $width = (int) ceil($currentWidth * $value);
            }

            $urls[$value . $unit] = $this->getUrl($imageName, $width, $mediaManagerType);
        }

        return $urls;
    }

    private function getUrl(string $imageName, ?int $width = null, ?string $mediaManagerType = null): string
    {
        if (!$width && !$mediaManagerType) {
            return rex_url::media($imageName);
        }

        $imageName = pathinfo($imageName, PATHINFO_FILENAME) . ($width ? '@' . $width . 'w' : '') . '.' . pathinfo($imageName, PATHINFO_EXTENSION);

        if ($mediaManagerType) {
            return sprintf('/images/%s/%s', $mediaManagerType, $imageName);
        }

        return sprintf('/images/%s', $imageName);
    }

    /**
     * Parses a srcset size (e.g. `100w` or `2x`).
     *
     * @throws InvalidArgumentException if the size can’t be parsed
     * @return array An array of the size value and unit (`w` or `x`)
     */
    protected function parseSrcsetSize(mixed $size): array
    {
        if (is_numeric($size)) {
            $size .= 'w';
        }
        if (!is_string($size)) {
            throw new InvalidArgumentException('Invalid srcset size');
        }
        $size = strtolower($size);
        if (!preg_match('/^([\d.]+)(w|x)$/', $size, $match)) {
            throw new InvalidArgumentException('Invalid srcset size: ' . $size);
        }
        return [(float) $match[1], $match[2]];
    }

    protected function addSource(array $srcset, string $format, ?string $sizes = null, int $mediaMinWidth = 0): void
    {
        $attributes = new HtmlAttributes();

        if ($mediaMinWidth > 0) {
            $attributes->set('media', '(min-width: ' . $mediaMinWidth . 'px)');
        }

        if ($sizes) {
            $attributes->set('sizes', $sizes);
        }

        $attributes->set('srcset', implode(', ', $srcset));
        $attributes->set('type', $format);
        $this->sources[] = $attributes;
    }

    public function render(): string
    {
        if ($this->resolutions instanceof ImageResolution) {
            $this->resolutions = ImageResolutionValues::getValue($this->resolutions);
        }

        sort($this->resolutions);

        $motifs = [];
        foreach ($this->motifs as $motif) {
            //            $motifs[$motif->fromBreakpoint->value] = $motif;
            $motifs[ImageBreakpointValues::getValue($motif->fromBreakpoint)] = $motif;
        }
        krsort($motifs);
        $this->motifs = $motifs;

        if (count($this->motifs) && is_array($this->resolutions)) {
            foreach ($this->resolutions as $resolution) {
                [$value, $unit] = $this->parseSrcsetSize($resolution);

                if ('x' === $unit) {
                    throw new InvalidArgumentException('Note that resolution for different motifs (art direction) only take effect when width descriptors are provided with srcset, not pixel density descriptors (i.e. 200w should be used instead of 2x).');
                }
            }
        }

        foreach ($this->motifs as $motif) {
            foreach ($this->formats as $format) {
                $imageName = $this->imageName;
                if ($format->value !== $this->fileMimeType) {
                    $imageName .= '.' . strtolower($format->name);
                }

                $this->addSource(
                    empty($this->resolutions)
                        ? [$this->getUrl($imageName, null, $motif->mediaManagerType)]
                        : $this->getSrcset($imageName, $this->resolutions, $motif->mediaManagerType),
                    $format->value,
                    $motif->sizes,
                    ImageBreakpointValues::getValue($motif->fromBreakpoint),
                );
            }
        }

        foreach ($this->formats as $format) {
            if ($format->value === $this->fileMimeType) {
                continue;
            }

            $this->addSource(
                empty($this->resolutions)
                    ? [$this->getUrl($this->imageName . '.' . strtolower($format->name), null, $this->mediaManagerType)]
                    : $this->getSrcset($this->imageName . '.' . strtolower($format->name), $this->resolutions, $this->mediaManagerType),
                $format->value,
                $this->sizes,
            );
        }

        if ($this->sizes) {
            $this->imageAttributes->set('sizes', $this->sizes);
        }

        if (count($this->resolutions)) {
            $srcset = $this->getSrcset($this->imageName, $this->resolutions, $this->mediaManagerType);

            $this->imageAttributes->set('src', reset($srcset));
            $this->imageAttributes->set('srcset', implode(', ', $srcset));
            //            [$width, $height] = $this->media->getDimensionsByMediaManagerType($this->mediaManagerType);
            //            $this->imageAttributes->set('width', $width);
            //            $this->imageAttributes->set('height', $height);
        } else {
            $this->imageAttributes->set('src', $this->getUrl($this->imageName, null, $this->mediaManagerType));
            //            [$width, $height] = $this->media->getDimensions();
            //            $this->imageAttributes->set('width', $width);
            //            $this->imageAttributes->set('height', $height);
        }

        /** @ToDo lowQualityPlaceholder
         *  Braucht width und height Angaben
         *  CSS reset
         */
        //        if ($this->lowQualityPlaceholder) {
        //            $this->imageAttributes->set('style', 'background-image: url('.$this->getUrl($this->imageName, 200, $this->lowQualityPlaceholder->mediaManagerType).')');
        //        }

        $this->imageAttributes->set('alt', $this->media->getAlt());
        $this->imageAttributes->set('loading', 'lazy');

        // Get caption from Media object
        if (true === $this->caption) {
            $this->caption = $this->media->getCaption();
        }

        // Get copyright from Media object
        if (true === $this->copyright) {
            $this->copyright = $this->media->getCopyright();
        }

        // If caption or copyright is available, then definitely output a figure tag.
        if ('' !== $this->caption || '' !== $this->copyright) {
            $this->figure = true;
        }

        return parent::render();
    }

    protected function getPath(): string
    {
        return 'Image.php';
    }
}
