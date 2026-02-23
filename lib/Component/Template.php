<?php

namespace Yakamara\Roadie\Component;

use InvalidArgumentException;
use rex_timer;
use rex_type;

use function sprintf;

use const DIRECTORY_SEPARATOR;

class Template
{
    /**
     * array which contains all folders in which templates will be searched for at runtime.
     *
     * @var list<string>
     */
    private static array $templateDirs = [];

    /**
     * Creates a template with the given variables.
     *
     * @param array<string, mixed> $vars A array of key-value pairs to pass as local parameters
     */
    public function __construct(array $vars = []) {}

    /**
     * Parses the variables of the template into the file $filename.
     *
     * @param string $filename the filename of the template to parse
     *
     * @throws InvalidArgumentException
     */
    public function parse(string $filename): string
    {
        foreach (self::$templateDirs as $templateDir) {
            $template = $templateDir . $filename;
            if (is_readable($template)) {
                return rex_timer::measure('Template: ' . $filename, function () use ($template) {
                    ob_start();
                    require $template;

                    return rex_type::string(ob_get_clean());
                });
            }
        }

        throw new InvalidArgumentException(sprintf('Template file "%s" not found!', $filename));
    }

    /**
     * Add a path to the template search path.
     *
     * @param string $dir A path to a directory where templates can be found
     */
    public static function addDirectory(string $dir): void
    {
        $dir = rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        array_unshift(self::$templateDirs, $dir);
    }

    /** @return array<string> */
    public static function getDirectories(): array
    {
        return self::$templateDirs;
    }
}
