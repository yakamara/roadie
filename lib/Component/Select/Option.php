<?php

namespace Yakamara\Roadie\Component\Select;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Select/templates/Option.php
 */
/**
 * @summary Options define the selectable items within a select.
 * @status stable
 * @since 1.0
 *
 * @slot - The option's label.
 * @slot start - An element placed before the label.
 * @slot end   - An element placed after the label.
 */
final class Option extends Component
{
    public function __construct(
        /**
         * The option's label.
         */
        public string|Component $label,

        /**
         * The option's value. This is what gets submitted with the form.
         */
        public ?string $value = null,

        /**
         * Draws the option in a disabled state, preventing selection.
         */
        public bool $disabled = false,

        /**
         * Selects this option initially.
         */
        public bool $defaultSelected = false,

        /**
         * An element placed before the label.
         */
        public string|Component|null $start = null,

        /**
         * An element placed after the label.
         */
        public string|Component|null $end = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Option.php';
    }
}
