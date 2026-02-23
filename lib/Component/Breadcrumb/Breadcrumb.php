<?php

namespace Yakamara\Roadie\Component\Breadcrumb;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Breadcrumb/templates/Breadcrumb.php
 */
/**
 * @summary Breadcrumbs provide a group of links so users can easily navigate a website's hierarchy.
 * @status stable
 * @since 1.0
 *
 * @slot - One or more <wa-breadcrumb-item> elements.
 * @slot separator - The separator to use between breadcrumb items.
 */
final class Breadcrumb extends Component
{
    public function __construct(
        /**
         * One or more breadcrumb items.
         *
         * @var list<BreadcrumbItem>
         */
        public array $items,

        /**
         * The label to use for the breadcrumb control (for assistive devices only).
         */
        public ?string $label = null,

        /**
         * Custom separator between items.
         */
        public string|Component|null $separator = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Breadcrumb.php';
    }
}
