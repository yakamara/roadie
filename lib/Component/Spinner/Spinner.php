<?php

namespace Yakamara\Roadie\Component\Spinner;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Spinner/templates/Spinner.php
 */
/**
 * @summary Spinners are used to show the progress of an indeterminate operation.
 * @status stable
 * @since 1.0
 */
final class Spinner extends Component
{
    public function __construct(
        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Spinner.php';
    }
}
