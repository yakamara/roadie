<?php

namespace Yakamara\Roadie\Component\Carousel;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Carousel/templates/CarouselItem.php
 */
/**
 * @summary Carousel items represent individual slides within a carousel.
 * @status stable
 * @since 1.0
 *
 * @slot - The carousel item's content.
 */
final class CarouselItem extends Component
{
    public function __construct(
        /**
         * The carousel item's content.
         */
        public string|Component $content,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'CarouselItem.php';
    }
}
