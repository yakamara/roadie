<?php

namespace Yakamara\Roadie\Component\AnimatedImage;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/AnimatedImage/templates/AnimatedImage.php
 */
/**
 * @summary Displays animated GIF and WEBP images with play/pause controls.
 * @status stable
 * @since 1.0
 *
 * @slot play-icon  - Custom play icon.
 * @slot pause-icon - Custom pause icon.
 */
final class AnimatedImage extends Component
{
    public function __construct(
        /**
         * Path to the animated GIF or WEBP image.
         */
        public ?string $src = null,

        /**
         * Description used by assistive devices.
         */
        public ?string $alt = null,

        /**
         * Plays the animation. Removing pauses it.
         */
        public bool $play = false,

        /**
         * Custom play icon.
         */
        public string|Component|null $playIcon = null,

        /**
         * Custom pause icon.
         */
        public string|Component|null $pauseIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'AnimatedImage.php';
    }
}
