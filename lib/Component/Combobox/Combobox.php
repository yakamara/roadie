<?php

namespace Yakamara\Roadie\Component\Combobox;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Select\Option;

/**
 * @see src/addons/roadie/lib/Component/Combobox/templates/Combobox.php
 */
/**
 * @summary Comboboxes allow the user to choose from a list of options, or type a custom value.
 * @status stable
 * @since 1.0
 *
 * @slot         - One or more <wa-option> elements.
 * @slot label   - The combobox's label. Overrides the label attribute.
 * @slot hint    - The combobox's hint text. Overrides the hint attribute.
 * @slot start   - An icon or element to show at the start of the control.
 * @slot end     - An icon or element to show at the end of the control.
 * @slot clear-icon  - An icon to use in lieu of the default clear icon.
 * @slot expand-icon - The icon to show when the control is expanded and collapsed.
 */
final class Combobox extends Component
{
    public function __construct(
        /**
         * One or more option elements.
         *
         * @var list<Option>
         */
        public array $options,

        /**
         * The combobox's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the combobox.
         */
        public string|Component|null $hint = null,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The current value.
         */
        public ?string $value = null,

        /**
         * Placeholder text shown when no option is selected.
         */
        public ?string $placeholder = null,

        /**
         * The combobox's size.
         */
        public ComboboxSize $size = ComboboxSize::Medium,

        /**
         * The combobox's visual appearance.
         */
        public ComboboxAppearance $appearance = ComboboxAppearance::Outlined,

        /**
         * Controls filtering behavior; List filters options, None shows all options.
         */
        public ComboboxAutocomplete $autocomplete = ComboboxAutocomplete::List,

        /**
         * Allows the user to enter a value that doesn't match any of the options.
         */
        public bool $allowCustomValue = false,

        /**
         * Allows more than one option to be selected.
         */
        public bool $multiple = false,

        /**
         * The maximum number of selected options to show when multiple is enabled.
         */
        public int $maxOptionsVisible = 3,

        /**
         * Disables the combobox.
         */
        public bool $disabled = false,

        /**
         * Makes the combobox a required field.
         */
        public bool $required = false,

        /**
         * Draws a pill-style combobox with rounded edges.
         */
        public bool $pill = false,

        /**
         * Adds a clear button.
         */
        public bool $withClear = false,

        /**
         * Opens the listbox.
         */
        public bool $open = false,

        /**
         * The preferred placement of the listbox.
         */
        public ComboboxPlacement $placement = ComboboxPlacement::Bottom,

        /**
         * An icon or element to show at the start of the control.
         */
        public string|Component|null $start = null,

        /**
         * An icon or element to show at the end of the control.
         */
        public string|Component|null $end = null,

        /**
         * An icon to use in lieu of the default clear icon.
         */
        public string|Component|null $clearIcon = null,

        /**
         * The icon to show when the control is expanded and collapsed.
         */
        public string|Component|null $expandIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Combobox.php';
    }
}
