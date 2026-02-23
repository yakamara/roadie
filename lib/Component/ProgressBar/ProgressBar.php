<?php

namespace Yakamara\Roadie\Component\ProgressBar;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/ProgressBar/templates/ProgressBar.php
 */
/**
 * @summary Progress bars are used to show the status of an ongoing operation.
 * @status stable
 * @since 1.0
 *
 * @slot - A label to show inside the progress indicator.
 */
final class ProgressBar extends Component
{
    public function __construct(
        /**
         * The current progress as a percentage, 0 to 100.
         */
        public int $value = 0,

        /**
         * When true, percentage is ignored, the label is hidden, and the progress
         * bar is drawn in an indeterminate state.
         */
        public bool $indeterminate = false,

        /**
         * A custom label for assistive devices.
         */
        public ?string $label = null,

        /**
         * A label to show inside the progress indicator.
         */
        public string|Component|null $indicator = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'ProgressBar.php';
    }
}
