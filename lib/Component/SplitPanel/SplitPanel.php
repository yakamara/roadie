<?php

namespace Yakamara\Roadie\Component\SplitPanel;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/SplitPanel/templates/SplitPanel.php
 */
/**
 * @summary Split panels divide a container into two resizable panels.
 * @status stable
 * @since 1.0
 *
 * @slot start   - Content for the start panel.
 * @slot end     - Content for the end panel.
 * @slot divider - Custom divider content (e.g. a drag handle icon).
 */
final class SplitPanel extends Component
{
    public function __construct(
        /**
         * Content for the start panel.
         */
        public string|Component|null $start = null,

        /**
         * Content for the end panel.
         */
        public string|Component|null $end = null,

        /**
         * Custom divider content.
         */
        public string|Component|null $divider = null,

        /**
         * Divider position from the primary panel's edge as a percentage (0–100).
         */
        public int $position = 50,

        /**
         * Divider position from the primary panel's edge in pixels.
         */
        public ?int $positionInPixels = null,

        /**
         * Panel layout direction.
         */
        public SplitPanelOrientation $orientation = SplitPanelOrientation::Horizontal,

        /**
         * Which panel is "primary" for resize behavior.
         */
        public ?SplitPanelPrimary $primary = null,

        /**
         * Space-separated snap points in px or % (e.g. "100px 50%").
         */
        public ?string $snap = null,

        /**
         * How close in pixels the divider must be to a snap point before snapping.
         */
        public int $snapThreshold = 12,

        /**
         * Disables resizing.
         */
        public bool $disabled = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'SplitPanel.php';
    }
}
