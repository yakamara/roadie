<?php
/**
 * forked from https://github.com/bpolaszek/webpack-encore-resolver
 */

namespace Yakamara\Roadie\Asset;

use InvalidArgumentException;
use rex_file;
use rex_functional_exception;
use rex_path;

final class AssetResolver
{
    private string $buildPath;

    /** @var array<string,array<string,string>>|null */
    private ?array $entryPoints = null;

    /** @var array<string,string>|null */
    private ?array $manifest = null;

    public function __construct(?string $buildPath = null)
    {
        $this->buildPath = rtrim($buildPath ?? rex_path::frontend('build'), '/').'/';
        $this->entryPoints = $this->loadJson('entrypoints.json');
        $this->manifest = $this->loadJson('manifest.json');
    }

    private function loadJson(string $fileName): array
    {
        $filePath = $this->buildPath . $fileName;
        if (file_exists($filePath)) {
            return json_decode(rex_file::get($filePath), true) ?? [];
        }
        return [];
    }
    public function getAssetUrl(string $asset): string
    {
        return $this->manifest['build/'.ltrim($asset, '/')] ?? $asset;
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

    public function getFontFiles(): array
    {
        $fonts = [];
        foreach ($this->manifest as $key => $path) {
            if (
                str_ends_with($key, '.woff2') ||
                str_ends_with($key, '.woff') ||
                str_ends_with($key, '.ttf') ||
                str_ends_with($key, '.otf') ||
                str_ends_with($key, '.eot')
            ) {
                $fonts[$path] = 'font/'.pathinfo($key, PATHINFO_EXTENSION);
            }
        }
        return $fonts;
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

//    /**
//     * @param string $resource
//     *
//     * @return string
//     * @throws rex_functional_exception
//     */
//    public function getAssetIcon(string $resource): string
//    {
//        $iconPath = '/build/assets/icons/';
//        $id = str_replace([$iconPath, '.svg', 'icon-'], '', $this->getAssetPath($iconPath . $resource . '.svg'));
//        return '<svg class="icon" aria-hidden="true" focusable="false"><use href="#icon-' . $id . '"></use></svg>';
//    }
//
//    /**
//     * @param string $resource
//     *
//     * @return string
//     * @throws rex_functional_exception
//     */
//    public function getAssetSvg(string $resource): string
//    {
//        $file = $this->getAssetPath('/build/'.$resource.'.svg');
//
//        if ($content = rex_file::get($file)) {
//            return $content;
//        }
//        return rex_file::get(rex_path::frontend(ltrim($file, '/')));
//    }
}
