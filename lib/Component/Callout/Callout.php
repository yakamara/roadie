<?php

namespace Yakamara\Roadie\Component\Callout;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Callout/templates/Callout.php
 */
/**
 * @summary Callouts are used to highlight important information within a page.
 * @status stable
 * @since 1.0
 *
 * @slot - The callout's main content.
 * @slot icon - An icon to show in the callout. Works best with <wa-icon>.
 */
final class Callout extends Component
{
    public function __construct(
        /**
         * The callout's main content.
         */
        public string|Component $content,

        /**
         * The callout's visual appearance.
         */
        public ?CalloutAppearance $appearance = null,

        /**
         * The callout's theme variant.
         */
        public CalloutVariant $variant = CalloutVariant::Brand,

        /**
         * The callout's size.
         */
        public CalloutSize $size = CalloutSize::Medium,

        /**
         * An icon to show in the callout. Works best with <wa-icon>.
         */
        public string|Component|null $icon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Callout.php';
    }
}
