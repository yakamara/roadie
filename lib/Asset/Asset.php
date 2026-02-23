<?php

namespace Yakamara\Roadie\Asset;

use rex_file;
use rex_path;

class Asset
{

    public static function url(string $fileName): string
    {
        return (new AssetResolver())->getAssetUrl($fileName);
    }

    /**
     * @param string      $entrypoint
     * @param string|null $directory
     *
     * @return string
     */
    public static function scriptTags(string $entrypoint, string $directory = null): string
    {
        $scriptTags = [];
        $assets = (new AssetResolver($directory))->getEntrypointFiles($entrypoint);
        foreach ($assets['js'] as $jsFile) {
            $scriptTags[] = '<script src="'.rex_escape($jsFile).'" defer></script>';
        }
        return implode("\n", $scriptTags);
    }

    /**
     * @param string      $entrypoint
     * @param string|null $directory
     *
     * @return string
     */
    public static function linkTags(string $entrypoint, string $directory = null): string
    {
        $linkTags = [];
        $resolver = new AssetResolver($directory);

        $fonts = $resolver->getFontFiles();
        foreach ($fonts as $fontFile => $fontType) {
            $linkTags[] = '<link rel="preload" href="' . rex_escape($fontFile) . '" as="font" type="' . $fontType . '" crossorigin="anonymous">';
        }

        $assets = $resolver->getEntrypointFiles($entrypoint);
        foreach ($assets['css'] as $cssFile) {
            $linkTags[] = '<link rel="stylesheet" href="'.rex_escape($cssFile).'">';
        }
        return implode("\n", $linkTags);
    }

    public static function svgInline(string $fileName): string
    {
        $url = self::url($fileName);
        if ($content = rex_file::get($url)) {
            return $content;
        }
        return rex_file::get(rex_path::frontend(ltrim($url, '/')));
    }

    public static function svgSymbol(string $symbolId, ?string $label = null): string
    {
        $cleanId = ltrim(str_replace(['.svg', 'icon-'], '', $symbolId), '/');
        return '<span class="icon" role="img"'.($label ? ' aria-label="'.rex_escape($label).'"' : '').'><svg class="icon" aria-hidden="true" focusable="false"><use xlink:href="#svg-'.rex_escape($cleanId).'"></use></svg></span>';
    }


//    /**
//     * @param string      $resource
//     * @param string|null $directory
//     *
//     * @return string
//     */
//    function get(string $resource, string $directory = null): string
//    {
//        try {
//            return (new AssetPathResolver($directory))->getAssetPath($resource);
//        } catch (rex_functional_exception $e) {
//            return rex_view::error($e->getMessage());
//        }
//    }
//
//    /**
//     * @param string      $resource
//     * @param string|null $directory
//     *
//     * @return string
//     */
//    public static function getSvg(string $resource, string $directory = null): string
//    {
//        try {
//            return (new AssetPathResolver($directory))->getAssetSvg($resource);
//        } catch (rex_functional_exception $e) {
//            return rex_view::error($e->getMessage());
//        }
//    }
//
//    /**
//     * @param string      $resource
//     * @param string|null $directory
//     *
//     * @return string
//     */
//    public static function getSvgIcon(string $resource, string $directory = null): string
//    {
//        try {
//            return (new AssetPathResolver($directory))->getAssetIcon($resource);
//        } catch (rex_functional_exception $e) {
//            return rex_view::error($e->getMessage());
//        }
//    }
//
//    /**
//     * @param string $resource
//     * @param string|null $directory
//     *
//     * @return string
//     */
//    public static function getSvgSprite(string $resource, string $directory = null): string
//    {
//        try {
//            $file = (new AssetPathResolver($directory))->getAssetSvg($resource);
//            return str_replace('<svg', '<svg style="position: absolute; width: 0; height: 0" aria-hidden="true"', $file);
//        } catch (rex_functional_exception $e) {
//            return rex_view::error($e->getMessage());
//        }
//    }
}