<?php

namespace Yakamara\Roadie\Component\Divider;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Divider/templates/Divider.php
 */
/**
 * @summary Dividers are used to visually separate or group elements.
 * @status stable
 * @since 1.0
 */
final class Divider extends Component
{
    public function __construct(
        /**
         * The divider's orientation.
         */
        public DividerOrientation $orientation = DividerOrientation::Horizontal,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Divider.php';
    }
}
