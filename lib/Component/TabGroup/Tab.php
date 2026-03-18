<?php

namespace Yakamara\Roadie\Component\TabGroup;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/TabGroup/templates/Tab.php
 */
/**
 * @summary Tabs are used inside tab groups to represent and activate tab panels.
 * @status stable
 * @since 1.0
 *
 * @slot - The tab's label.
 */
final class Tab extends Component
{
    public function __construct(
        /**
         * The tab's label.
         */
        public string|Component $label,

        /**
         * The content of the tab panel.
         */
        public string|Component $panel,

        /**
         * The tab panel's name.
         * Required. Otherwise, the group cannot function correctly.
         */
        public string $name,

        /**
         * When true, the tab panel will be shown.
         */
        public bool $active = false,

        /**
         * Disables the tab and prevents selection.
         */
        public bool $disabled = false,

        public HtmlAttributes $tabAttributes = new HtmlAttributes(),

        public HtmlAttributes $panelAttributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Tab.php';
    }
}
