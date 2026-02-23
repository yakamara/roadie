<?php

namespace Yakamara\Roadie\Component;

use rex_exception;

use function is_string;

abstract class Component extends TemplateRender
{
    public function __toString(): string
    {
        return $this->render();
    }

    public static function slot(string|self|null $content, ?string $name = null): string
    {
        if (null === $content) {
            return '';
        }

        if (is_string($content)) {
            $content = rex_escape($content);

            return $name ? '<div slot="' . rex_escape($name) . '">' . $content . '</div>' : $content;
        }

        if (null === $name) {
            return trim($content->render());
        }

        if (isset($content->attributes) && $content->attributes instanceof HtmlAttributes) {
            $content->attributes->set('slot', $name);

            return trim($content->render());
        }

        $content = trim($content->render());

        $count = 0;
        $content = preg_replace('/^(<([a-z-]+[0-6]?))/', '$1 slot="' . rex_escape($name) . '"', $content, count: $count);

        if (1 !== $count) {
            throw new rex_exception('The content of the slot "' . $name . '" must start with an HTML element');
        }

        return $content;
    }
}
