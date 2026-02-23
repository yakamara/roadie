<?php

namespace Yakamara\Roadie\Component\TabGroup;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/TabGroup/templates/TabPanel.php
 */
/**
 * @summary Tab panels are used inside tab groups to display tab content.
 * @status stable
 * @since 1.0
 *
 * @slot - The tab panel's content.
 */
final class TabPanel extends Component
{
    public function __construct(
        /**
         * The tab panel's content.
         */
        public string|Component $content,

        /**
         * The tab panel's name. Must match the panel attribute of the corresponding <wa-tab>.
         */
        public ?string $name = null,

        /**
         * When true, the tab panel will be shown.
         */
        public bool $active = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'TabPanel.php';
    }
}
