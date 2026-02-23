<?php

namespace Yakamara\Roadie\Component\Animation;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Animation/templates/Animation.php
 */
/**
 * @summary Animates elements using the Web Animations API.
 * @status stable
 * @since 1.0
 *
 * @slot - The element to animate. Only the first slotted element is animated.
 */
final class Animation extends Component
{
    public function __construct(
        /**
         * The element to animate.
         */
        public string|Component $content,

        /**
         * Built-in animation name. Ignored if keyframes is set.
         */
        public ?string $name = null,

        /**
         * Triggers playback. Auto-removed when the animation finishes or is cancelled.
         */
        public bool $play = false,

        /**
         * Milliseconds per iteration.
         */
        public int $duration = 1000,

        /**
         * Milliseconds to wait before the animation starts.
         */
        public int $delay = 0,

        /**
         * Milliseconds of delay after the active animation period.
         */
        public int $endDelay = 0,

        /**
         * Easing function or custom cubic-bezier() value.
         */
        public ?string $easing = null,

        /**
         * Number of iterations before the animation completes. Null means infinite.
         */
        public ?float $iterations = null,

        /**
         * Offset to start the animation, range 0–1.
         */
        public float $iterationStart = 0,

        /**
         * Playback direction behavior.
         */
        public AnimationDirection $direction = AnimationDirection::Normal,

        /**
         * How styles apply before/after execution.
         */
        public AnimationFill $fill = AnimationFill::Auto,

        /**
         * Speed multiplier (e.g. 2 = double speed).
         */
        public float $playbackRate = 1,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Animation.php';
    }
}
