<?php

namespace Yakamara\Roadie\Component\RadioGroup;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Radio\Radio;

/**
 * @see src/addons/roadie/lib/Component/RadioGroup/templates/RadioGroup.php
 */
/**
 * @summary Radio groups are used to group multiple radios or radio buttons so they function as a single form control.
 * @status stable
 * @since 1.0
 *
 * @slot - One or more <wa-radio> elements.
 * @slot label - The radio group's label. Overrides the label attribute.
 * @slot hint  - The radio group's hint text. Overrides the hint attribute.
 */
final class RadioGroup extends Component
{
    public function __construct(
        /**
         * One or more radio elements.
         *
         * @var list<Radio>
         */
        public array $radios,

        /**
         * The radio group's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the group.
         */
        public string|Component|null $hint = null,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * The currently selected value.
         */
        public ?string $value = null,

        /**
         * The default value. Primarily used to reset the field.
         */
        public ?string $defaultValue = null,

        /**
         * The orientation of the radio group.
         */
        public RadioGroupOrientation $orientation = RadioGroupOrientation::Vertical,

        /**
         * The size of the radios in this group.
         */
        public ?RadioGroupSize $size = null,

        /**
         * Disables the radio group.
         */
        public bool $disabled = false,

        /**
         * Makes the radio group a required field.
         */
        public bool $required = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'RadioGroup.php';
    }
}
