<?php

namespace Yakamara\Roadie\Component\Scroller;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Scroller/templates/Scroller.php
 */
/**
 * @summary Scrollers add scroll behavior with optional arrows and shadows to any overflow content.
 * @status stable
 * @since 1.0
 *
 * @slot - The content to scroll.
 */
final class Scroller extends Component
{
    public function __construct(
        /**
         * The content to display inside the scroller.
         */
        public string|Component $content,

        /**
         * The scroll direction.
         */
        public ScrollerOrientation $orientation = ScrollerOrientation::Horizontal,

        /**
         * Removes the visible scrollbar.
         */
        public bool $withoutScrollbar = false,

        /**
         * Removes the edge shadow indicators.
         */
        public bool $withoutShadow = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Scroller.php';
    }
}
