<?php

namespace Yakamara\Roadie\Component\ProgressRing;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/ProgressRing/templates/ProgressRing.php
 */
/**
 * @summary Progress rings are used to show the progress of a determinate operation in a circular fashion.
 * @status stable
 * @since 1.0
 *
 * @slot - A label to show inside the ring.
 */
final class ProgressRing extends Component
{
    public function __construct(
        /**
         * The current progress as a percentage, 0 to 100.
         */
        public int $value = 0,

        /**
         * A custom label for assistive devices.
         */
        public ?string $label = null,

        /**
         * A label to show inside the ring.
         */
        public string|Component|null $indicator = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'ProgressRing.php';
    }
}
