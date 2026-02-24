<?php

namespace Yakamara\Roadie\Util;

use InvalidArgumentException;
use rex_file;
use rex_path;

use function in_array;

final class FileTypeDetector
{
    private const array EXTENSIONS = [
        'image' => ['avif', 'bmp', 'gif', 'jpeg', 'jpg', 'png', 'webp'],
        'audio' => ['aac', 'flac', 'mp3', 'ogg', 'wav', 'webm'],
        'video' => ['avi', 'mov', 'mp4', 'mpeg', 'ogg', 'webm'],
        'svg' => ['svg'],
    ];

    private const array MIME_TYPES = [
        'image' => ['image/avif', 'image/bmp', 'image/gif', 'image/jpeg', 'image/png', 'image/webp'],
        'audio' => ['audio/aac', 'audio/flac', 'audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/webm'],
        'video' => ['video/avi', 'video/quicktime', 'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm'],
        'svg' => ['image/svg+xml'],
    ];

    public function __construct(
        public string $filePath,
    ) {
        if ($this->filePath === basename($this->filePath)) {
            $this->filePath = rex_path::media($this->filePath);
        }
        if (!is_file($this->filePath) || !is_readable($this->filePath)) {
            throw new InvalidArgumentException('File does not exist or is not readable: ' . $this->filePath);
        }
    }

    /**
     * Returns whether an extension is web-safe image.
     */
    public function isRasterImage(): bool
    {
        return $this->matchesType('image');
    }

    public function isSvg(): bool
    {
        return $this->matchesType('svg');
    }

    /**
     * Returns whether an extension is web-safe audio.
     */
    public function isAudio(): bool
    {
        return $this->matchesType('audio');
    }

    /**
     * Returns whether an extension is web-safe video.
     */
    public function isVideo(): bool
    {
        return $this->matchesType('video');
    }

    public function getExtension(): string
    {
        return rex_file::extension($this->filePath);
    }

    public function getMimeType(): string
    {
        return rex_file::mimeType($this->filePath);
    }

    private function matchesType(string $type): bool
    {
        $extension = $this->getExtension();
        $mimeType = $this->getMimeType();
        return ($extension && in_array($extension, self::EXTENSIONS[$type], true)) && ($mimeType && in_array($mimeType, self::MIME_TYPES[$type], true));
    }
}
