<?php

namespace Yakamara\Roadie\Component\Dropdown;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Html;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Dropdown/templates/Dropdown.php
 */
/**
 * @summary Dropdowns expose additional content that "drops down" in a panel when triggered.
 * @status stable
 * @since 1.0
 *
 * @slot         - One or more <wa-dropdown-item> elements.
 * @slot trigger - The element that triggers the dropdown (e.g. a button).
 */
final class Dropdown extends Component
{
    public function __construct(
        /**
         * The element that triggers the dropdown.
         */
        public string|Component $trigger,

        /**
         * One or more dropdown items, components or raw HTML strings.
         *
         * @var list<DropdownItem|Component|string>
         */
        public array $items,

        /**
         * Preferred placement of the menu relative to the trigger.
         */
        public DropdownPlacement $placement = DropdownPlacement::BottomStart,

        /**
         * The dropdown's size.
         */
        public DropdownSize $size = DropdownSize::Medium,

        /**
         * Opens or closes the dropdown.
         */
        public bool $open = false,

        /**
         * Gap in pixels between the menu and its trigger.
         */
        public int $distance = 0,

        /**
         * Offset in pixels of the menu along the trigger axis.
         */
        public int $skidding = 0,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Dropdown.php';
    }
}
