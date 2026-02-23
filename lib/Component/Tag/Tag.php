<?php

namespace Yakamara\Roadie\Component\Tag;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Tag/templates/Tag.php
 */
/**
 * @summary Tags are used as labels to organize things or to indicate a selection.
 * @status stable
 * @since 1.0
 *
 * @slot - The tag's content.
 */
final class Tag extends Component
{
    public function __construct(
        /**
         * The tag's content.
         */
        public string|Component $label,

        /**
         * The tag's visual appearance.
         */
        public TagAppearance $appearance = TagAppearance::FilledOutlined,

        /**
         * The tag's theme variant.
         */
        public TagVariant $variant = TagVariant::Neutral,

        /**
         * The tag's size.
         */
        public TagSize $size = TagSize::Medium,

        /**
         * Draws a pill-style tag with rounded edges.
         */
        public bool $pill = false,

        /**
         * Makes the tag removable and shows a remove button.
         */
        public bool $withRemove = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Tag.php';
    }
}
