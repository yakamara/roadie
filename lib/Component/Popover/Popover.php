<?php

namespace Yakamara\Roadie\Component\Popover;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Popover/templates/Popover.php
 */
/**
 * @summary Popovers display contextual content and interactive elements in a floating panel.
 * @status stable
 * @since 1.0
 *
 * @slot - The popover's content. Interactive elements such as buttons and links are supported.
 */
final class Popover extends Component
{
    public function __construct(
        /**
         * The popover's content.
         */
        public string|Component|null $content = null,

        /**
         * The ID of the anchor element (must be interactive/focusable, e.g. a button).
         */
        public ?string $targetId = null,

        /**
         * Shows or hides the popover.
         */
        public bool $open = false,

        /**
         * Preferred placement of the popover.
         */
        public PopoverPlacement $placement = PopoverPlacement::Top,

        /**
         * Offset distance in pixels away from the target.
         */
        public int $distance = 8,

        /**
         * Offset in pixels along the target axis.
         */
        public int $skidding = 0,

        /**
         * Removes the arrow from the popover.
         */
        public bool $withoutArrow = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Popover.php';
    }
}
