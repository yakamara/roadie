<?php

namespace Yakamara\Roadie\Component\TabGroup;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/TabGroup/templates/TabGroup.php
 */
/**
 * @summary Tab groups organize content into a container that shows one section at a time.
 * @status stable
 * @since 1.0
 *
 * @slot - One or more <wa-tab-panel> elements.
 * @slot nav - One or more <wa-tab> elements.
 */
final class TabGroup extends Component
{
    public function __construct(
        /**
         * One or more tab panels.
         *
         * @var list<TabPanel>
         */
        public array $panels,

        /**
         * One or more tabs for the nav slot.
         *
         * @var list<Tab>
         */
        public array $tabs,

        /**
         * The placement of the tab bar.
         */
        public TabGroupPlacement $placement = TabGroupPlacement::Top,

        /**
         * When set to auto, navigating tabs with the arrow keys will
         * instantly show the corresponding tab panel. When set to manual,
         * the tab will receive focus but will not show until the user
         * presses space or enter.
         */
        public TabGroupActivation $activation = TabGroupActivation::Auto,

        /**
         * The name of the currently active tab panel.
         */
        public ?string $active = null,

        /**
         * Disables the scroll arrows that appear when tabs overflow.
         */
        public bool $withoutScrollControls = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'TabGroup.php';
    }
}
