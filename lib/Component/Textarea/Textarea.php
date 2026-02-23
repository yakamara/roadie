<?php

namespace Yakamara\Roadie\Component\Textarea;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttribute\Autocapitalize;
use Yakamara\Roadie\Component\HtmlAttribute\Autocorrect;
use Yakamara\Roadie\Component\HtmlAttribute\Enterkeyhint;
use Yakamara\Roadie\Component\HtmlAttribute\Inputmode;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Textarea/templates/Textarea.php
 */
/**
 * @summary Textareas collect data from the user and allow multiple lines of text.
 * @status stable
 * @since 1.0
 *
 * @slot label - The textarea's label. Overrides the label attribute.
 * @slot hint  - The textarea's hint text. Overrides the hint attribute.
 */
final class Textarea extends Component
{
    public function __construct(
        /**
         * The textarea's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the textarea.
         */
        public string|Component|null $hint = null,

        /**
         * The textarea's current value.
         */
        public ?string $value = null,

        /**
         * The default value. Primarily used to reset the field.
         */
        public ?string $defaultValue = null,

        /**
         * Placeholder text shown when the textarea has no value.
         */
        public ?string $placeholder = null,

        /**
         * The textarea's size.
         */
        public TextareaSize $size = TextareaSize::Medium,

        /**
         * The textarea's visual appearance.
         */
        public TextareaAppearance $appearance = TextareaAppearance::Outlined,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * Disables the textarea.
         */
        public bool $disabled = false,

        /**
         * Makes the textarea readonly.
         */
        public bool $readonly = false,

        /**
         * Makes the textarea a required field.
         */
        public bool $required = false,

        /**
         * The number of rows to display.
         */
        public int $rows = 4,

        /**
         * Controls how the textarea can be resized.
         */
        public TextareaResize $resize = TextareaResize::Vertical,

        /**
         * The minimum length of input accepted.
         */
        public ?int $minlength = null,

        /**
         * The maximum length of input accepted.
         */
        public ?int $maxlength = null,

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

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Textarea.php';
    }
}
