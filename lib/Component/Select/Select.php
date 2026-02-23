<?php

namespace Yakamara\Roadie\Component\Select;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Select/templates/Select.php
 */
/**
 * @summary Selects allow you to choose items from a menu of predefined options.
 * @status stable
 * @since 1.0
 *
 * @slot              - One or more <wa-option> elements.
 * @slot label        - The select's label. Overrides the label attribute.
 * @slot hint         - The select's hint text. Overrides the hint attribute.
 * @slot start        - An icon or element to show at the start of the control.
 * @slot end          - An icon or element to show at the end of the control.
 * @slot clear-icon   - An icon to use in lieu of the default clear icon.
 * @slot expand-icon  - The icon to show when the control is expanded and collapsed.
 */
final class Select extends Component
{
    public function __construct(
        /**
         * One or more option elements.
         *
         * @var list<Option>
         */
        public array $options,

        /**
         * The select's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the select.
         */
        public string|Component|null $hint = null,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The current value (option value or array of values for multiple).
         */
        public ?string $value = null,

        /**
         * Placeholder text shown when no option is selected.
         */
        public ?string $placeholder = null,

        /**
         * The select's size.
         */
        public SelectSize $size = SelectSize::Medium,

        /**
         * The select's visual appearance.
         */
        public SelectAppearance $appearance = SelectAppearance::Outlined,

        /**
         * Allows more than one option to be selected.
         */
        public bool $multiple = false,

        /**
         * The maximum number of selected options to show when multiple is enabled.
         */
        public int $maxOptionsVisible = 3,

        /**
         * Disables the select.
         */
        public bool $disabled = false,

        /**
         * Makes the select a required field.
         */
        public bool $required = false,

        /**
         * Draws a pill-style select with rounded edges.
         */
        public bool $pill = false,

        /**
         * Adds a clear button.
         */
        public bool $withClear = false,

        /**
         * Indicates whether the select's listbox is open.
         */
        public bool $open = false,

        /**
         * The preferred placement of the listbox.
         */
        public SelectPlacement $placement = SelectPlacement::Bottom,

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
        return 'Select.php';
    }
}
