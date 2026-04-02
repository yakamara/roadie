<?php

namespace Yakamara\Roadie\Console;

use rex_console_command;
use rex_dir;
use rex_file;
use rex_path;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yakamara\Roadie\Icons\IconRegistry;

class GenerateIconManifestCommand extends rex_console_command
{
    protected function configure(): void
    {
        $this->setDescription('Generates the icon manifest from SVG files');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $iconsDir = IconRegistry::getIconsDirectory();
        $defaultLib = IconRegistry::getDefaultLibrary();
        $metaFile = IconRegistry::getMetaFile();
        $outputPath = rex_path::addonData('roadie', 'icons.json');

        if (!is_dir($iconsDir)) {
            $output->writeln('<error>Icons-Verzeichnis nicht gefunden: ' . $iconsDir . '</error>');
            return self::FAILURE;
        }

        // Optionale Meta-Datei laden (Labels, Keywords)
        $meta = [];
        if ($metaFile && file_exists($metaFile)) {
            $meta = json_decode(file_get_contents($metaFile), true) ?? [];
        }

        // Unterordner = Libraries
        $libraryNames = array_values(array_filter(
            scandir($iconsDir),
            fn($d) => $d !== '.' && $d !== '..' && is_dir($iconsDir . '/' . $d),
        ));
        sort($libraryNames);

        if (empty($libraryNames)) {
            $output->writeln('<error>Keine Library-Ordner gefunden in: ' . $iconsDir . '</error>');
            return self::FAILURE;
        }

        $libraries = [];
        $total = 0;

        foreach ($libraryNames as $libraryName) {
            $dir = $iconsDir . '/' . $libraryName;
            $files = array_values(array_filter(scandir($dir), fn($f) => str_ends_with($f, '.svg')));
            sort($files);

            $icons = [];
            foreach ($files as $file) {
                $name = substr($file, 0, -4);
                $raw = file_get_contents($dir . '/' . $file);

                $iconMeta = $meta[$libraryName . '/' . $name] ?? $meta[$name] ?? null;

                $icons[] = [
                    'name' => $name,
                    'label' => $iconMeta['label'] ?? self::humanize($name),
                    'keywords' => $iconMeta['keywords'] ?? [],
                    'svg' => self::cleanSvg($raw),
                ];
            }

            $libraries[] = [
                'name' => $libraryName,
                'isDefault' => $libraryName === $defaultLib,
                'icons' => $icons,
            ];

            $total += count($icons);
        }

        $manifest = [
            'defaultLibrary' => $defaultLib,
            'libraries' => $libraries,
        ];

        rex_dir::create(dirname($outputPath));
        rex_file::put($outputPath, json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $output->writeln(sprintf(
            '<info>Icon-Manifest generiert: %d Icons in %d Librar%s → %s</info>',
            $total,
            count($libraries),
            count($libraries) === 1 ? 'y' : 'ies',
            $outputPath,
        ));

        foreach ($libraries as $lib) {
            $output->writeln(sprintf(
                '  %s%s: %d Icons',
                $lib['name'],
                $lib['isDefault'] ? ' (default)' : '',
                count($lib['icons']),
            ));
        }

        return self::SUCCESS;
    }

    private static function humanize(string $name): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $name));
    }

    private static function cleanSvg(string $svg): string
    {
        // XML-Deklaration, DOCTYPE, Kommentare
        $svg = preg_replace('/<\?xml[^>]*\?>/', '', $svg);
        $svg = preg_replace('/<!DOCTYPE[^>]*>/i', '', $svg);
        $svg = preg_replace('/<!--[\s\S]*?-->/', '', $svg);

        // <title> und <desc>
        $svg = preg_replace('/<title[^>]*>[\s\S]*?<\/title>/i', '', $svg);
        $svg = preg_replace('/<desc[^>]*>[\s\S]*?<\/desc>/i', '', $svg);

        // width/height vom <svg>-Tag entfernen
        $svg = preg_replace('/(<svg\b[^>]*?)\s+width="[^"]*"/i', '$1', $svg);
        $svg = preg_replace('/(<svg\b[^>]*?)\s+height="[^"]*"/i', '$1', $svg);

        // xmlns sicherstellen
        if (!str_contains($svg, 'xmlns=')) {
            $svg = str_replace('<svg', '<svg xmlns="http://www.w3.org/2000/svg"', $svg);
        }

        // fill="*" → fill="currentColor", fill="none" bleibt
        $svg = preg_replace('/\bfill="(?!none")[^"]*"/', 'fill="currentColor"', $svg);

        // Whitespace normalisieren
        $svg = preg_replace('/\s*\n\s*/', ' ', $svg);
        $svg = preg_replace('/\s{2,}/', ' ', $svg);

        return trim($svg);
    }
}
