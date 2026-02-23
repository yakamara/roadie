<?php

namespace Yakamara\Roadie\Component\Switch;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Switch/templates/SwitchToggle.php
 */
/**
 * @summary Switches allow the user to toggle an option on or off.
 * @status stable
 * @since 1.0
 *
 * @slot - The switch's label.
 * @slot hint - Descriptive text that appears below the label.
 */
final class SwitchToggle extends Component
{
    public function __construct(
        /**
         * The switch's label.
         */
        public string|Component $label,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The value submitted when the switch is checked.
         */
        public ?string $value = null,

        /**
         * Draws the switch in a checked state.
         */
        public bool $checked = false,

        /**
         * The default checked state. Primarily used to reset the field.
         */
        public bool $defaultChecked = false,

        /**
         * Disables the switch.
         */
        public bool $disabled = false,

        /**
         * Makes the switch a required field.
         */
        public bool $required = false,

        /**
         * The switch's size.
         */
        public SwitchSize $size = SwitchSize::Medium,

        /**
         * Descriptive hint text shown below the label.
         */
        public string|Component|null $hint = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'SwitchToggle.php';
    }
}
