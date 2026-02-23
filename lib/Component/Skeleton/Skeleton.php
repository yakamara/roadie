<?php

namespace Yakamara\Roadie\Component\Skeleton;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Skeleton/templates/Skeleton.php
 */
/**
 * @summary Skeletons are used to provide a low fidelity representation of content before it appears on the page.
 * @status stable
 * @since 1.0
 */
final class Skeleton extends Component
{
    public function __construct(
        /**
         * Determines the animation effect of the skeleton.
         */
        public SkeletonEffect $effect = SkeletonEffect::None,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Skeleton.php';
    }
}
