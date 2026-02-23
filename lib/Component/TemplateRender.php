<?php

namespace Yakamara\Roadie\Component;

use Closure;
use rex_exception;
use rex_timer;
use rex_type;

use function sprintf;

class TemplateRender
{
    public function render(): string
    {
        $path = $this->getPath();
        $fullPath = $this->resolvePath($path);

        /** @var Closure():string $closure */
        $closure = Closure::bind(function () use ($fullPath) {
            ob_start();
            require $fullPath;

            return rex_type::string(ob_get_clean());
        }, $this, static::class);

        $output = rex_timer::measure('Template: ' . $path, $closure);

        return rex_type::string($output);
    }

    protected function getPath(): string
    {
        throw new rex_exception('Missing template path for component class "' . static::class . '"');
    }

    public static function resolvePath(string $path): string
    {
        foreach (Template::getDirectories() as $templateDir) {
            $template = $templateDir . $path;
            if (!is_file($template)) {
                continue;
            }

            return $template;
        }

        throw new rex_exception(sprintf('Template file "%s" not found!', $path));
    }
}
