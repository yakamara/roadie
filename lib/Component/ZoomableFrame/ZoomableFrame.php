<?php

namespace Yakamara\Roadie\Component\ZoomableFrame;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/ZoomableFrame/templates/ZoomableFrame.php
 */
/**
 * @summary Displays content inside a zoomable iframe with zoom controls.
 * @status stable
 * @since 1.0
 *
 * @slot zoom-in-icon  - Custom zoom-in icon.
 * @slot zoom-out-icon - Custom zoom-out icon.
 */
final class ZoomableFrame extends Component
{
    public function __construct(
        /**
         * URL of the embedded content.
         */
        public ?string $src = null,

        /**
         * Inline HTML rendered within the iframe.
         */
        public ?string $srcdoc = null,

        /**
         * Controls how iframe content loads.
         */
        public ZoomableFrameLoading $loading = ZoomableFrameLoading::Eager,

        /**
         * Permits fullscreen mode activation.
         */
        public bool $allowfullscreen = false,

        /**
         * Applies security restrictions to the iframe.
         */
        public ?string $sandbox = null,

        /**
         * Manages referrer information sharing.
         */
        public ?string $referrerpolicy = null,

        /**
         * Hides the zoom control interface.
         */
        public bool $withoutControls = false,

        /**
         * Disables user interactions with the frame.
         */
        public bool $withoutInteraction = false,

        /**
         * Current zoom level (1 = 100%).
         */
        public float $zoom = 1,

        /**
         * Space-separated zoom increments for the controls.
         */
        public ?string $zoomLevels = null,

        /**
         * Custom zoom-in icon.
         */
        public string|Component|null $zoomInIcon = null,

        /**
         * Custom zoom-out icon.
         */
        public string|Component|null $zoomOutIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'ZoomableFrame.php';
    }
}
