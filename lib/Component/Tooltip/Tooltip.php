<?php

namespace Yakamara\Roadie\Component\Tooltip;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Tooltip/templates/Tooltip.php
 */
/**
 * @summary Tooltips display additional information based on a specific action.
 * @status stable
 * @since 1.0
 *
 * @slot - The tooltip's content. Interactive content should be avoided.
 */
final class Tooltip extends Component
{
    public function __construct(
        /**
         * The tooltip's text content shown in the bubble.
         */
        public string|Component $content,

        /**
         * The ID of the element the tooltip is anchored to.
         * Maps to the `for` attribute on <wa-tooltip>.
         */
        public ?string $targetId = null,

        /**
         * The preferred placement of the tooltip.
         */
        public TooltipPlacement $placement = TooltipPlacement::Top,

        /**
         * Controls how the tooltip is activated.
         * Possible options: "click", "hover", "focus", "manual".
         */
        public string $trigger = 'hover focus',

        /**
         * The distance in pixels from which to offset the tooltip away from its target.
         */
        public int $distance = 8,

        /**
         * The distance in pixels from which to offset the tooltip along its target.
         */
        public int $skidding = 0,

        /**
         * The delay in milliseconds before the tooltip is shown.
         */
        public int $showDelay = 150,

        /**
         * The delay in milliseconds before the tooltip is hidden.
         */
        public int $hideDelay = 0,

        /**
         * Indicates whether or not the tooltip is open.
         */
        public bool $open = false,

        /**
         * Disables the tooltip so it won't show when triggered.
         */
        public bool $disabled = false,

        /**
         * Removes the arrow pointer from the tooltip.
         */
        public bool $withoutArrow = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Tooltip.php';
    }
}
