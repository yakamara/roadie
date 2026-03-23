<?php

namespace Yakamara\Roadie\Component\Details;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Details/templates/Details.php
 */
/**
 * @summary Details show a brief summary and expand to show additional content.
 * @status stable
 * @since 1.0
 *
 * @slot - The details' main content.
 * @slot summary       - The summary to show when collapsed. Overrides the summary attribute.
 * @slot expand-icon   - Optional expand icon.
 * @slot collapse-icon - Optional collapse icon.
 */
final class Details extends Component
{
    public function __construct(
        /**
         * The summary to show as the toggle label. Can also be set via the summary slot.
         */
        public string|Component $summary,

        /**
         * The details' main content shown when expanded.
         */
        public string|Component $content,

        /**
         * The details' visual appearance.
         */
        public DetailsAppearance $appearance = DetailsAppearance::Outlined,

        /**
         * Indicates whether the details is open.
         */
        public bool $open = false,

        /**
         * Disables the details so it can't be toggled.
         */
        public bool $disabled = false,

        /**
         * The placement of the expand/collapse icon.
         */
        public DetailsIconPlacement $iconPlacement = DetailsIconPlacement::End,

        /**
         * The name of the details. Used for grouping exclusive details panels.
         */
        public ?string $name = null,

        /**
         * Custom expand icon.
         */
        public string|Component|null $expandIcon = null,

        /**
         * Custom collapse icon.
         */
        public string|Component|null $collapseIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Details.php';
    }
}
