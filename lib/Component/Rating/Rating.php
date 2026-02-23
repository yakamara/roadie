<?php

namespace Yakamara\Roadie\Component\Rating;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Rating/templates/Rating.php
 */
/**
 * @summary Ratings give users a way to quickly view and provide feedback.
 * @status stable
 * @since 1.0
 */
final class Rating extends Component
{
    public function __construct(
        /**
         * The current rating.
         */
        public float $value = 0,

        /**
         * The highest rating to show.
         */
        public int $max = 5,

        /**
         * The precision at which the rating will increase and decrease.
         * For example, to allow half-star ratings, set this to 0.5.
         */
        public float $precision = 1,

        /**
         * The rating's size.
         */
        public RatingSize $size = RatingSize::Medium,

        /**
         * A label that describes the rating to assistive devices.
         */
        public ?string $label = null,

        /**
         * Disables the rating.
         */
        public bool $disabled = false,

        /**
         * Makes the rating readonly.
         */
        public bool $readonly = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Rating.php';
    }
}
