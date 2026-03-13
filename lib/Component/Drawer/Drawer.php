<?php

namespace Yakamara\Roadie\Component\Drawer;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Drawer/templates/Drawer.php
 */
/**
 * @summary Drawers slide in from a container to expose additional options and information.
 * @status stable
 * @since 1.0
 *
 * @slot - The drawer's main content.
 * @slot label          - The drawer's label. Overrides the label attribute.
 * @slot header-actions - Optional buttons or controls placed in the header.
 * @slot footer         - The drawer's footer, usually one or more buttons.
 */
final class Drawer extends Component
{
    public function __construct(
        /**
         * The drawer's main content.
         */
        public string|Component $content,

        /**
         * The drawer's label shown in the header.
         */
        public string|Component|null $label = null,

        /**
         * The direction from which the drawer will open.
         */
        public DrawerPlacement $placement = DrawerPlacement::End,

        /**
         * Indicates whether the drawer is open.
         */
        public bool $open = false,

        /**
         * When true, the drawer closes when the user clicks outside of it.
         */
        public bool $lightDismiss = true,

        /**
         * Removes the header and the default close button.
         */
        public bool $withoutHeader = false,

        /**
         * Optional buttons or controls placed in the header.
         */
        public string|Component|null $headerActions = null,

        /**
         * The drawer's footer, usually one or more buttons.
         */
        public string|Component|null $footer = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Drawer.php';
    }
}
