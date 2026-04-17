<?php

namespace Yakamara\Roadie\Component\Dialog;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Icon\Icon;

/**
 * @see src/addons/roadie/lib/Component/Dialog/templates/Dialog.php
 */
/**
 * @summary Dialogs, sometimes called "modals", appear above the page and require the user's immediate attention.
 * @status stable
 * @since 1.0
 *
 * @slot - The dialog's main content.
 * @slot label          - The dialog's label. Overrides the label attribute.
 * @slot header-actions - Optional buttons or controls placed in the header.
 * @slot footer         - The dialog's footer, usually one or more buttons.
 */
final class Dialog extends Component
{
    public function __construct(
        /**
         * The dialog's main content.
         */
        public string|Component $content,

        /**
         * The dialog's label shown in the header.
         */
        public ?string $label = null,

        /**
         * Indicates whether the dialog is open.
         */
        public bool $open = false,

        /**
         * Allows the dialog to be closed by clicking outside of it.
         */
        public bool $lightDismiss = false,

        /**
         * Removes the header and the default close button.
         */
        public bool $withoutHeader = false,

        /**
         * Custom label content (overrides the label attribute).
         */
        public string|Component|null $labelSlot = null,

        /**
         * Optional buttons or controls placed in the header.
         */
        public string|Component|null $headerActions = null,

        /**
         * The dialog's footer, usually one or more buttons.
         */
        public string|Component|null $footer = null,

        /**
         * Custom icon for the close button. Replaces the default system icon.
         */
        public ?Icon $closeIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Dialog.php';
    }
}
