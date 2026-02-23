<?php

namespace Yakamara\Roadie\Component\Comparison;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Comparison/templates/Comparison.php
 */
/**
 * @summary Compares two images visually using a draggable divider.
 * @status stable
 * @since 1.0
 *
 * @slot before - The "before" image or content.
 * @slot after  - The "after" image or content.
 * @slot handle - Custom icon inside the drag handle.
 */
final class Comparison extends Component
{
    public function __construct(
        /**
         * The "before" content, typically an image.
         */
        public string|Component|null $before = null,

        /**
         * The "after" content, typically an image.
         */
        public string|Component|null $after = null,

        /**
         * Custom icon inside the drag handle.
         */
        public string|Component|null $handle = null,

        /**
         * Position of the divider as a percentage (0–100).
         */
        public int $position = 50,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Comparison.php';
    }
}
