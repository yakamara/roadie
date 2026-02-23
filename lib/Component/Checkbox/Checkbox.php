<?php

namespace Yakamara\Roadie\Component\Checkbox;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Checkbox/templates/Checkbox.php
 */
/**
 * @summary Checkboxes allow the user to toggle an option on or off.
 * @status stable
 * @since 1.0
 *
 * @slot - The checkbox's label.
 * @slot hint - Descriptive text that appears below the label.
 */
final class Checkbox extends Component
{
    public function __construct(
        /**
         * The checkbox's label.
         */
        public string|Component $label,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The value of the checkbox when checked.
         */
        public ?string $value = null,

        /**
         * Draws the checkbox in a checked state.
         */
        public bool $checked = false,

        /**
         * The default checked state. Primarily used to reset the field.
         */
        public bool $defaultChecked = false,

        /**
         * Draws the checkbox in an indeterminate state.
         */
        public bool $indeterminate = false,

        /**
         * Disables the checkbox.
         */
        public bool $disabled = false,

        /**
         * Makes the checkbox a required field.
         */
        public bool $required = false,

        /**
         * The checkbox's size.
         */
        public CheckboxSize $size = CheckboxSize::Medium,

        /**
         * Descriptive hint text shown below the label.
         */
        public string|Component|null $hint = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Checkbox.php';
    }
}
