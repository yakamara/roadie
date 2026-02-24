<?php

/**
 * forked from https://github.com/bpolaszek/webpack-encore-resolver.
 */

namespace Yakamara\Roadie\Asset;

use rex_file;
use rex_path;

final class AssetResolver
{
    private string $buildPath;

    /** @var array<string,array<string,string>>|null */
    private ?array $entryPoints = null;

    /** @var array<string,string>|null */
    private ?array $manifest = null;

    /** @var array<string,array<mixed>> */
    private static array $cache = [];

    public function __construct(?string $buildPath = null)
    {
        $this->buildPath = rtrim($buildPath ?? rex_path::frontend('build'), '/') . '/';
        $this->entryPoints = $this->loadJson('entrypoints.json');
        $this->manifest = $this->loadJson('manifest.json');
    }

    private function loadJson(string $fileName): array
    {
        $filePath = $this->buildPath . $fileName;
        return self::$cache[$filePath] ??= (file_exists($filePath)
            ? json_decode(rex_file::get($filePath), true) ?? []
            : []);
    }

    public function getAssetUrl(string $asset): string
    {
        return $this->manifest['build/' . ltrim($asset, '/')] ?? $asset;
    }

    public function getEntrypointFiles(string $entryName): array
    {
        $entry = $this->entryPoints['entrypoints'][$entryName] ?? null;
        if (!$entry) {
            return ['js' => [], 'css' => []];
        }

        return [
            'js' => $entry['js'] ?? [],
            'css' => $entry['css'] ?? [],
        ];
    }

    public function getSvgFiles(): array
    {
        $svgs = [];
        foreach ($this->manifest as $key => $path) {
            if (str_ends_with($key, '.svg')) {
                $svgs[] = $path;
            }
        }
        return $svgs;
    }
}
