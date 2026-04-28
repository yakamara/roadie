<?php

namespace Yakamara\Roadie\Widget\LayoutPicker;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Widget/LayoutPicker/templates/LayoutPicker.php
 */
final class LayoutPicker extends Component
{
    public function __construct(
        /**
         * The available layout options.
         *
         * @var list<LayoutPickerOption>
         */
        public array $options,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The currently selected value.
         */
        public ?string $value = null,

        /**
         * The picker's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the group.
         */
        public string|Component|null $hint = null,

        /**
         * Makes the picker a required field.
         */
        public bool $required = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'LayoutPicker.php';
    }
}
