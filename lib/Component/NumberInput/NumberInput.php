<?php

namespace Yakamara\Roadie\Component\NumberInput;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttribute\Enterkeyhint;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/NumberInput/templates/NumberInput.php
 */
/**
 * @summary Number inputs collect numeric data from the user.
 * @status stable
 * @since 1.0
 *
 * @slot label          - The input's label. Overrides the label attribute.
 * @slot hint           - The input's hint. Overrides the hint attribute.
 * @slot start          - An icon or element to place before the input.
 * @slot end            - An icon or element to place before the steppers.
 * @slot increment-icon - Icon for the increment button.
 * @slot decrement-icon - Icon for the decrement button.
 */
final class NumberInput extends Component
{
    public function __construct(
        /**
         * The input's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the input.
         */
        public string|Component|null $hint = null,

        /**
         * The current value.
         */
        public ?string $value = null,

        /**
         * The default value. Primarily used to reset the field.
         */
        public ?string $defaultValue = null,

        /**
         * Placeholder text shown when the input has no value.
         */
        public ?string $placeholder = null,

        /**
         * The input's size.
         */
        public NumberInputSize $size = NumberInputSize::Medium,

        /**
         * The input's visual appearance.
         */
        public NumberInputAppearance $appearance = NumberInputAppearance::Outlined,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The minimum value allowed.
         */
        public ?int $min = null,

        /**
         * The maximum value allowed.
         */
        public ?int $max = null,

        /**
         * The step increment.
         */
        public ?string $step = null,

        /**
         * Disables the input.
         */
        public bool $disabled = false,

        /**
         * Makes the input readonly.
         */
        public bool $readonly = false,

        /**
         * Makes the input a required field.
         */
        public bool $required = false,

        /**
         * Draws a pill-style input with rounded edges.
         */
        public bool $pill = false,

        /**
         * Hides the increment/decrement stepper buttons.
         */
        public bool $withoutSteppers = false,

        /**
         * Controls how the browser autocompletes the field.
         */
        public ?string $autocomplete = null,

        /**
         * Focuses the control automatically when the page loads.
         */
        public bool $autofocus = false,

        /**
         * Customizes the label or icon of the Enter key on virtual keyboards.
         */
        public ?Enterkeyhint $enterkeyhint = null,

        /**
         * Tells the browser what type of virtual keyboard to display. Limited to numeric or decimal for number inputs.
         */
        public ?NumberInputInputmode $inputmode = null,

        /**
         * An icon or element placed before the input.
         */
        public string|Component|null $start = null,

        /**
         * An icon or element placed before the steppers.
         */
        public string|Component|null $end = null,

        /**
         * Custom increment icon.
         */
        public string|Component|null $incrementIcon = null,

        /**
         * Custom decrement icon.
         */
        public string|Component|null $decrementIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'NumberInput.php';
    }
}
