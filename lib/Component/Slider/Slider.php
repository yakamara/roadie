<?php

namespace Yakamara\Roadie\Component\Slider;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Slider/templates/Slider.php
 */
/**
 * @summary Sliders allow the user to select a value within a given range by dragging a thumb.
 * @status stable
 * @since 1.0
 *
 * @slot label     - The slider's label.
 * @slot hint      - Descriptive text that appears below the slider.
 * @slot reference - One or more reference labels shown below the slider.
 */
final class Slider extends Component
{
    public function __construct(
        /**
         * The slider's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the slider.
         */
        public string|Component|null $hint = null,

        /**
         * The current value.
         */
        public ?float $value = null,

        /**
         * The default value. Primarily used to reset the field.
         */
        public ?float $defaultValue = null,

        /**
         * The minimum allowed value.
         */
        public float $min = 0,

        /**
         * The maximum allowed value.
         */
        public float $max = 100,

        /**
         * The step increment.
         */
        public float $step = 1,

        /**
         * The orientation of the slider.
         */
        public SliderOrientation $orientation = SliderOrientation::Horizontal,

        /**
         * The slider's size.
         */
        public SliderSize $size = SliderSize::Medium,

        /**
         * The name of the form control.
         */
        public ?string $name = null,

        /**
         * Focuses the control automatically when the page loads.
         */
        public bool $autofocus = false,

        /**
         * Disables the slider.
         */
        public bool $disabled = false,

        /**
         * Makes the slider readonly.
         */
        public bool $readonly = false,

        /**
         * Makes the slider a required field.
         */
        public bool $required = false,

        /**
         * Enables range mode with two thumbs.
         */
        public bool $range = false,

        /**
         * Shows tick marks along the slider.
         */
        public bool $withMarkers = false,

        /**
         * Shows a tooltip when dragging the thumb.
         */
        public bool $withTooltip = false,

        /**
         * The distance in pixels from the indicator to offset. Used to visually align indicators.
         */
        public ?float $indicatorOffset = null,

        /**
         * The distance in pixels from the thumb at which to show the tooltip.
         */
        public int $tooltipDistance = 8,

        /**
         * The preferred placement of the tooltip.
         */
        public SliderTooltipPlacement $tooltipPlacement = SliderTooltipPlacement::Top,

        /**
         * Reference labels shown below the slider.
         */
        public string|Component|null $reference = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Slider.php';
    }
}
