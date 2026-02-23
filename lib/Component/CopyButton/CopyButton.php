<?php

namespace Yakamara\Roadie\Component\CopyButton;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/CopyButton/templates/CopyButton.php
 */
/**
 * @summary Generates a QR code and renders it using the Canvas API.
 * @status stable
 * @since 1.0
 *
 * @slot copy-icon    - The icon to show in the default copy state.
 * @slot success-icon - The icon to show when the content is copied.
 * @slot error-icon   - The icon to show when a copy error occurs.
 */
final class CopyButton extends Component
{
    public function __construct(
        /**
         * The text value to copy.
         */
        public ?string $value = null,

        /**
         * An id that references an element in the same document from which data will be copied.
         * If both this and value are present, this takes precedence.
         */
        public ?string $from = null,

        /**
         * Disables the copy button.
         */
        public bool $disabled = false,

        /**
         * A label to show in the tooltip for the copy state.
         */
        public ?string $copyLabel = null,

        /**
         * A label to show in the tooltip for the success state.
         */
        public ?string $successLabel = null,

        /**
         * A label to show in the tooltip for the error state.
         */
        public ?string $errorLabel = null,

        /**
         * The length of time to show feedback before restoring the default trigger.
         * In milliseconds.
         */
        public int $feedbackDuration = 1000,

        /**
         * The preferred placement of the tooltip.
         */
        public CopyButtonTooltipPlacement $tooltipPlacement = CopyButtonTooltipPlacement::Top,

        /**
         * The icon to show in the default copy state.
         */
        public string|Component|null $copyIcon = null,

        /**
         * The icon to show when the content is copied.
         */
        public string|Component|null $successIcon = null,

        /**
         * The icon to show when a copy error occurs.
         */
        public string|Component|null $errorIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'CopyButton.php';
    }
}
