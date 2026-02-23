<?php

namespace Yakamara\Roadie\Component\Dropdown;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Dropdown/templates/DropdownItem.php
 */
/**
 * @summary Dropdown items represent individual items within a dropdown menu.
 * @status stable
 * @since 1.0
 *
 * @slot         - The dropdown item's label.
 * @slot icon    - An optional icon to display before the label.
 * @slot details - Additional content displayed after the label (e.g. keyboard shortcut).
 * @slot submenu - Nested menu items, typically <wa-dropdown-item> elements.
 */
final class DropdownItem extends Component
{
    public function __construct(
        /**
         * The dropdown item's label.
         */
        public string|Component $label,

        /**
         * Optional value for determining which item was selected.
         */
        public ?string $value = null,

        /**
         * The type of menu item to render.
         */
        public DropdownItemType $type = DropdownItemType::Normal,

        /**
         * The visual variant; use Danger for destructive actions.
         */
        public DropdownItemVariant $variant = DropdownItemVariant::Default,

        /**
         * Set to true to check the item when type is Checkbox.
         */
        public bool $checked = false,

        /**
         * Disables the dropdown item.
         */
        public bool $disabled = false,

        /**
         * An optional icon to display before the label.
         */
        public string|Component|null $icon = null,

        /**
         * Additional content displayed after the label (e.g. keyboard shortcut).
         */
        public string|Component|null $details = null,

        /**
         * Nested menu items for a submenu.
         */
        public string|Component|null $submenu = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'DropdownItem.php';
    }
}
