<?php

namespace Yakamara\Roadie\Component\Badge;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Badge/templates/Badge.php
 */
/**
 * @summary Badges are used to draw attention and display statuses or counts.
 * @status stable
 * @since 1.0
 *
 * @slot - The badge's content.
 */
final class Badge extends Component
{
    public function __construct(
        /**
         * The badge's content.
         */
        public string|Component $label,

        /**
         * The badge's visual appearance.
         */
        public BadgeAppearance $appearance = BadgeAppearance::Accent,

        /**
         * The badge's theme variant.
         */
        public BadgeVariant $variant = BadgeVariant::Brand,

        /**
         * Applies an animation to draw attention to the badge.
         */
        public BadgeAttention $attention = BadgeAttention::None,

        /**
         * Draws a pill-style badge with rounded edges.
         */
        public bool $pill = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Badge.php';
    }
}
