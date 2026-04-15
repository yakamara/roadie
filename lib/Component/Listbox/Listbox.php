<?php

namespace Yakamara\Roadie\Component\Listbox;

use Yakamara\Roadie\Component\Button\Button;
use Yakamara\Roadie\Component\Button\ListboxAppearance;
use Yakamara\Roadie\Component\Button\ListboxVariant;
use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Html;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Icon\Icon;

/**
 * @see src/addons/roadie/lib/Component/Dropdown/templates/Listbox.php
 */
/**
 * @summary Listboxes expose additional content that "drops down" in a panel when triggered.
 * @status stable
 * @since 1.0
 *
 * @slot         - Components or HTML strings
 * @slot trigger - The element that triggers the listbox (e.g. a button).
 */
final class Listbox extends Component
{
    public function __construct(
        public string $trigger,

        /**
         * One or more items, components or raw HTML strings.
         *
         * @var list<ListboxItem>
         */
        public array $items,

        public string $label,

        public ListboxPlacement $placement = ListboxPlacement::BottomEnd,

        public ?Icon $start = null,

        public ?Icon $end = null,

        /**
         * The listbox appearance.
         */
        public ListboxAppearance $appearance = ListboxAppearance::Accent,

        /**
         * The listbox theme variant.
         */
        public ListboxVariant $variant = ListboxVariant::Brand,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Listbox.php';
    }
}
