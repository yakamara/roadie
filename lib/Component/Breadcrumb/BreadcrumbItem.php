<?php

namespace Yakamara\Roadie\Component\Breadcrumb;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Breadcrumb/templates/BreadcrumbItem.php
 */
/**
 * @summary Breadcrumb items are used inside breadcrumbs to represent different links.
 * @status stable
 * @since 1.0
 *
 * @slot           - The breadcrumb item's label.
 * @slot start     - An element, such as <wa-icon>, placed before the label.
 * @slot end       - An element, such as <wa-icon>, placed after the label.
 * @slot separator - A custom separator to use after this item, overriding the breadcrumb's separator.
 */
final class BreadcrumbItem extends Component
{
    public function __construct(
        /**
         * The item's label.
         */
        public string|Component $label,

        /**
         * Optional URL. When set, the item renders as a link.
         */
        public ?string $href = null,

        /**
         * Tells the browser where to open the link. Only used when href is present.
         */
        public ?string $target = null,

        /**
         * The rel attribute for the link. Defaults to 'noreferrer noopener' for security.
         */
        public string $rel = 'noreferrer noopener',

        /**
         * An element placed before the label.
         */
        public string|Component|null $start = null,

        /**
         * An element placed after the label.
         */
        public string|Component|null $end = null,

        /**
         * A custom separator to use after the item, overriding the breadcrumb's separator.
         */
        public string|Component|null $separator = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'BreadcrumbItem.php';
    }
}
