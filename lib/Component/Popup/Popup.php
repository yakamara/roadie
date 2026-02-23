<?php

namespace Yakamara\Roadie\Component\Popup;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Popup/templates/Popup.php
 */
/**
 * @summary Popup is a low-level utility for positioning elements relative to an anchor.
 * @status stable
 * @since 1.0
 *
 * @slot        - The popup's content.
 * @slot anchor - The anchor element, when it lives outside the popup.
 */
final class Popup extends Component
{
    public function __construct(
        /**
         * The popup's content.
         */
        public string|Component|null $content = null,

        /**
         * The anchor element as a slot, when it lives outside the popup.
         */
        public string|Component|null $anchorSlot = null,

        /**
         * The ID of the anchor element, or use the anchor slot.
         */
        public ?string $anchor = null,

        /**
         * Activates positioning logic and shows the popup.
         */
        public bool $active = false,

        /**
         * Preferred popup placement.
         */
        public PopupPlacement $placement = PopupPlacement::Top,

        /**
         * Pixel offset away from the anchor.
         */
        public int $distance = 0,

        /**
         * Pixel offset along the anchor axis.
         */
        public int $skidding = 0,

        /**
         * Attaches an arrow to the popup.
         */
        public bool $arrow = false,

        /**
         * Padding between the arrow and popup edges.
         */
        public int $arrowPadding = 10,

        /**
         * Arrow alignment relative to anchor or popup.
         */
        public PopupArrowPlacement $arrowPlacement = PopupArrowPlacement::Anchor,

        /**
         * Auto-resize to prevent overflow.
         */
        public ?PopupAutoSize $autoSize = null,

        /**
         * Pixel threshold before auto-size activates.
         */
        public int $autoSizePadding = 0,

        /**
         * Bounding box for flip/shift/auto-size.
         */
        public PopupBoundary $boundary = PopupBoundary::Viewport,

        /**
         * Flips placement to the opposite side to stay in view.
         */
        public bool $flip = false,

        /**
         * Space-separated fallback placements (e.g. "top bottom left").
         */
        public ?string $flipFallbackPlacements = null,

        /**
         * Strategy when no placement fits.
         */
        public PopupFlipFallbackStrategy $flipFallbackStrategy = PopupFlipFallbackStrategy::BestFit,

        /**
         * Pixel threshold before flip activates.
         */
        public int $flipPadding = 0,

        /**
         * Moves the popup along its axis to prevent clipping.
         */
        public bool $shift = false,

        /**
         * Pixel threshold before shift activates.
         */
        public int $shiftPadding = 0,

        /**
         * Syncs popup dimensions to the anchor.
         */
        public ?PopupSync $sync = null,

        /**
         * Renders an invisible element filling the gap between anchor and popup.
         */
        public bool $hoverBridge = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Popup.php';
    }
}
