<?php

namespace Yakamara\Roadie\Component\ColorPicker;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/ColorPicker/templates/ColorPicker.php
 */
/**
 * @summary Color pickers allow the user to select a color.
 * @status stable
 * @since 1.0
 *
 * @slot label - The color picker's label. Overrides the label attribute.
 * @slot hint  - The color picker's hint text. Overrides the hint attribute.
 */
final class ColorPicker extends Component
{
    public function __construct(
        /**
         * The color picker's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the color picker.
         */
        public string|Component|null $hint = null,

        /**
         * The current color value.
         */
        public ?string $value = null,

        /**
         * Default form control value used when resetting.
         */
        public ?string $defaultValue = null,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * Output color format.
         */
        public ColorPickerFormat $format = ColorPickerFormat::Hex,

        /**
         * The trigger button size.
         */
        public ColorPickerSize $size = ColorPickerSize::Medium,

        /**
         * Shows opacity slider; converts values to HEXA/RGBA/HSLA.
         */
        public bool $opacity = false,

        /**
         * Controls popup visibility.
         */
        public bool $open = false,

        /**
         * Disables the color picker.
         */
        public bool $disabled = false,

        /**
         * Makes the field required for form validation.
         */
        public bool $required = false,

        /**
         * Displays hex/color values in uppercase.
         */
        public bool $uppercase = false,

        /**
         * Removes the format toggle button.
         */
        public bool $withoutFormatToggle = false,

        /**
         * Preset colors as semicolon-separated string (e.g. "#ff0000;#00ff00").
         */
        public ?string $swatches = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'ColorPicker.php';
    }
}
