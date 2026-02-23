<?php

namespace Yakamara\Roadie\Component\Carousel;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Carousel/templates/Carousel.php
 */
/**
 * @summary Carousels display an arbitrary number of content slides along a horizontal or vertical axis.
 * @status stable
 * @since 1.0
 *
 * @slot               - One or more <wa-carousel-item> elements.
 * @slot previous-icon - Custom icon for the previous button.
 * @slot next-icon     - Custom icon for the next button.
 */
final class Carousel extends Component
{
    public function __construct(
        /**
         * One or more carousel items.
         *
         * @var list<CarouselItem>
         */
        public array $items,

        /**
         * Layout direction of the carousel.
         */
        public CarouselOrientation $orientation = CarouselOrientation::Horizontal,

        /**
         * Number of slides visible simultaneously.
         */
        public int $slidesPerPage = 1,

        /**
         * Number of slides advanced per navigation action.
         */
        public int $slidesPerMove = 1,

        /**
         * Shows previous/next navigation buttons.
         */
        public bool $navigation = false,

        /**
         * Shows pagination dot indicators.
         */
        public bool $pagination = false,

        /**
         * Allows infinite navigation in one direction.
         */
        public bool $loop = false,

        /**
         * Enables click-and-drag scrolling on desktop.
         */
        public bool $mouseDragging = false,

        /**
         * Auto-scrolls slides when user is not interacting.
         */
        public bool $autoplay = false,

        /**
         * Milliseconds between automatic advances.
         */
        public int $autoplayInterval = 3000,

        /**
         * Custom previous button icon.
         */
        public string|Component|null $previousIcon = null,

        /**
         * Custom next button icon.
         */
        public string|Component|null $nextIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Carousel.php';
    }
}
