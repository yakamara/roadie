<?php

namespace Yakamara\Roadie\Widget\LayoutPicker;

readonly class LayoutPickerOption
{
    public function __construct(
        /**
         * The SVG markup used as visual preview.
         */
        public string $svg,

        /**
         * The value submitted with the form when this option is selected.
         */
        public string $value,

        /**
         * An optional text label shown below the SVG preview.
         */
        public ?string $label = null,

        /**
         * Disables this option.
         */
        public bool $disabled = false,
    ) {}
}
