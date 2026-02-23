<?php

namespace Yakamara\Roadie\Component\FormatBytes;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/FormatBytes/templates/FormatBytes.php
 */
/**
 * @summary Formats a number as a human-readable bytes value.
 * @status stable
 * @since 1.0
 */
final class FormatBytes extends Component
{
    public function __construct(
        /**
         * The number to format in bytes.
         */
        public float $value = 0,

        /**
         * The type of unit to display.
         */
        public FormatBytesUnit $unit = FormatBytesUnit::Byte,

        /**
         * Determines how to display the result.
         */
        public FormatBytesDisplay $display = FormatBytesDisplay::Short,

        /**
         * The locale to use for formatting. Defaults to the browser's locale.
         */
        public ?string $lang = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'FormatBytes.php';
    }
}
