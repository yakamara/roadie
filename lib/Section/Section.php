<?php

namespace Yakamara\Roadie\Section;

use rex;
use rex_extension_point;
use rex_string;

use function count;

use const PREG_SET_ORDER;

class Section
{
    private const string PLACEHOLDER_OPEN = '{{{';
    private const string PLACEHOLDER_CLOSE = '}}}';
    private const string PLACEHOLDER_PREFIX = 'SECTION_';
    private const string INNER_TAG = 'div';

    private static array $instances;

    private string $placeholder;

    public function __construct(
        public array $attributes = [],

        public string $tag = 'div',

        public array $innerAttributes = [],
    ) {
        $this->placeholder = self::PLACEHOLDER_PREFIX . random_int(100, 999) . random_int(100, 999);
        self::$instances[$this->placeholder] = $this;
    }

    protected function getAttributes(): array
    {
        return $this->attributes;
    }

    protected function hasInnerTag(): bool
    {
        return count($this->innerAttributes);
    }

    protected function getInnerAttributes(): array
    {
        return $this->innerAttributes;
    }

    protected function getTag(): string
    {
        return $this->tag;
    }

    public function getPlaceholder(): string
    {
        if (rex::isFrontend()) {
            return self::PLACEHOLDER_OPEN . $this->placeholder . self::PLACEHOLDER_CLOSE;
        }

        $attributes = array_merge_recursive(['class' => 'roadie-section'], $this->getAttributes());
        return '<div' . rex_string::buildAttributes($attributes) . '>' . self::PLACEHOLDER_OPEN . $this->placeholder . self::PLACEHOLDER_CLOSE . '</div>';
    }

    public static function replace(rex_extension_point $ep): void
    {
        $subject = $ep->getSubject();
        preg_match_all('@(?<placeholder_with_tags>' . preg_quote(self::PLACEHOLDER_OPEN) . '\s*(?<placeholder>' . self::PLACEHOLDER_PREFIX . '[0-9]{6})\s*' . preg_quote(self::PLACEHOLDER_CLOSE) . ')@', $subject, $matches, PREG_SET_ORDER);

        if (0 === count($matches)) {
            return;
        }

        $placeholders = [];
        foreach ($matches as $match) {
            if (isset(self::$instances[$match['placeholder']])) {
                $placeholders[] = self::$instances[$match['placeholder']];
            }
        }
        $search = [];
        $replace = [];

        $lastTag = '';
        $outerTagIsOpen = false;
        $innerTagIsOpen = false;
        /** @var self $placeholder */
        foreach ($placeholders as $placeholder) {
            $html = '';

            if ($innerTagIsOpen) {
                $html .= '</' . self::INNER_TAG . '>';
            }

            if ($outerTagIsOpen) {
                $html .= '</' . $lastTag . '>';
            }

            $html .= '<' . $placeholder->getTag() . rex_string::buildAttributes($placeholder->getAttributes()) . '>';
            $outerTagIsOpen = true;

            if ($placeholder->hasInnerTag()) {
                $html .= '<' . self::INNER_TAG . rex_string::buildAttributes($placeholder->getInnerAttributes()) . '>';
                $innerTagIsOpen = true;
            }

            $search[] = $placeholder->getPlaceholder();
            $replace[] = $html;

            $lastTag = $placeholder->getTag();
        }

        $subject = str_replace($search, $replace, $subject);
        if ($innerTagIsOpen) {
            $subject .= '</' . self::INNER_TAG . '>';
        }
        if ($outerTagIsOpen) {
            $subject .= '</' . $lastTag . '>';
        }

        $ep->setSubject($subject);
    }
}
