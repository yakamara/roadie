<?php

namespace Yakamara\Roadie\Component\Listbox;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Icon\Icon;

/**
 * @see src/addons/roadie/lib/Component/Listbox/templates/ListboxItem.php
 */
/**
 * @summary Listbox items represent individual items within a listbox menu.
 * @status stable
 * @since 1.0
 *
 * @slot         - The listbox item's label.
 * @slot start   - An optional icon to display before the label.
 * @slot end     - An optional icon to display after the label.
 */
final class ListboxItem extends Component
{
    public function __construct(
        /**
         * The listbox item's label.
         */
        public string $label,

        /**
         * value for determining which item was selected.
         */
        public ?string $value = null,

        public ?string $href = null,

        public ?Icon $start = null,

        public ?Icon $end = null,

        /**
         * Set to true to check the item when type is Checkbox.
         */
        public bool $selected = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'ListboxItem.php';
    }
}
