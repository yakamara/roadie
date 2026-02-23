<?php

namespace Yakamara\Roadie\Component\Radio;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Radio/templates/Radio.php
 */
/**
 * @summary Radios allow the user to select a single option from a group.
 * @status stable
 * @since 1.0
 *
 * @slot - The radio's label.
 */
final class Radio extends Component
{
    public function __construct(
        /**
         * The radio's label.
         */
        public string|Component $label,

        /**
         * The radio's value. Submitted with the form when this radio is selected.
         */
        public ?string $value = null,

        /**
         * The radio's visual appearance.
         */
        public RadioAppearance $appearance = RadioAppearance::Default,

        /**
         * The radio's size. Overrides the parent radio group's size.
         */
        public ?RadioSize $size = null,

        /**
         * Disables the radio.
         */
        public bool $disabled = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Radio.php';
    }
}
