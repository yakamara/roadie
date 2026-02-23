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
         * The name of the tab panel this tab is associated with.
         * Must match the name attribute of the corresponding <wa-tab-panel>.
         */
        public ?string $panel = null,

        /**
         * Disables the tab and prevents selection.
         */
        public bool $disabled = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Tab.php';
    }
}
