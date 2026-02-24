<?php

namespace Yakamara\Roadie\Component\Input;

use InvalidArgumentException;
use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttribute\Autocapitalize;
use Yakamara\Roadie\Component\HtmlAttribute\Autocorrect;
use Yakamara\Roadie\Component\HtmlAttribute\Enterkeyhint;
use Yakamara\Roadie\Component\HtmlAttribute\Inputmode;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Input/templates/Input.php
 */
/**
 * @summary Inputs collect data from the user.
 * @status stable
 * @since 1.0
 *
 * @slot label             - The input's label. Overrides the label attribute.
 * @slot hint              - The input's hint text. Overrides the hint attribute.
 * @slot start             - An icon or similar element to place before the input.
 * @slot end               - An icon or similar element to place after the input.
 * @slot clear-icon        - An icon to use in lieu of the default clear icon.
 * @slot show-password-icon - An icon to use in lieu of the default show password icon.
 * @slot hide-password-icon - An icon to use in lieu of the default hide password icon.
 */
final class Input extends Component
{
    public function __construct(
        /**
         * The type of input.
         */
        public InputType $type = InputType::Text,

        /**
         * The input's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the input.
         */
        public string|Component|null $hint = null,

        /**
         * The name of the form control, submitted as a name/value pair with form data.
         */
        public ?string $name = null,

        /**
         * The input's current value.
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
        public InputSize $size = InputSize::Medium,

        /**
         * The input's visual appearance.
         */
        public InputAppearance $appearance = InputAppearance::Outlined,

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
         * Adds a clear button when the user has entered a value.
         */
        public bool $withClear = false,

        /**
         * Adds a button to toggle the password's visibility. Only applies to password inputs.
         */
        public bool $passwordToggle = false,

        /**
         * Shows the password as plain text. Only applies to password inputs with passwordToggle.
         */
        public bool $passwordVisible = false,

        /**
         * Hides the browser's built-in increment/decrement spin buttons. Only applies to number inputs.
         */
        public bool $withoutSpinButtons = false,

        /**
         * The minimum length of input accepted by the control.
         */
        public ?int $minlength = null,

        /**
         * The maximum length of input accepted by the control.
         */
        public ?int $maxlength = null,

        /**
         * The minimum value allowed (for number/date inputs).
         */
        public int|string|null $min = null,

        /**
         * The maximum value allowed (for number/date inputs).
         */
        public int|string|null $max = null,

        /**
         * The step to use for number inputs.
         */
        public int|string|null $step = null,

        /**
         * A regular expression pattern to validate the input against.
         */
        public ?string $pattern = null,

        /**
         * Controls how the browser autocompletes the field.
         */
        public ?string $autocomplete = null,

        /**
         * Controls whether and how text input is automatically capitalized.
         */
        public ?Autocapitalize $autocapitalize = null,

        /**
         * Controls autocorrect behavior on iOS devices.
         */
        public ?Autocorrect $autocorrect = null,

        /**
         * Enables or disables spell checking. Null uses the browser default.
         */
        public ?bool $spellcheck = null,

        /**
         * Focuses the control automatically when the page loads.
         */
        public bool $autofocus = false,

        /**
         * Customizes the label or icon of the Enter key on virtual keyboards.
         */
        public ?Enterkeyhint $enterkeyhint = null,

        /**
         * Tells the browser what type of virtual keyboard to display.
         */
        public ?Inputmode $inputmode = null,

        /**
         * An icon or element to place before the input.
         */
        public string|Component|null $start = null,

        /**
         * An icon or element to place after the input.
         */
        public string|Component|null $end = null,

        /**
         * An icon to use in lieu of the default clear icon.
         */
        public string|Component|null $clearIcon = null,

        /**
         * An icon to use in lieu of the default show password icon.
         */
        public string|Component|null $showPasswordIcon = null,

        /**
         * An icon to use in lieu of the default hide password icon.
         */
        public string|Component|null $hidePasswordIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {
        if (null !== $this->min && !$this->type->supportsMinMaxStep()) {
            throw new InvalidArgumentException('The min property applies to date and number input types. The current type is ' . $this->type->name . '.');
        }
        if (null !== $this->max && !$this->type->supportsMinMaxStep()) {
            throw new InvalidArgumentException('The max property applies to date and number input types. The current type is ' . $this->type->name . '.');
        }
        if (null !== $this->step && !$this->type->supportsMinMaxStep()) {
            throw new InvalidArgumentException('The step property applies to date and number input types. The current type is ' . $this->type->name . '.');
        }
    }

    protected function getPath(): string
    {
        return 'Input.php';
    }
}
