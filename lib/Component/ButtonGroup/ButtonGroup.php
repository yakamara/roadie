<?php

namespace Yakamara\Roadie\Component\ButtonGroup;

use Yakamara\Roadie\Component\Button\Button;
use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/ButtonGroup/templates/ButtonGroup.php
 */
/**
 * @summary Button groups can be used to group related buttons into sections.
 * @status stable
 * @since 1.0
 *
 * @slot - One or more <wa-button> elements to display in the group.
 */
final class ButtonGroup extends Component
{
    public function __construct(
        /**
         * One or more buttons to display in the group.
         *
         * @var list<Button>
         */
        public array $buttons,

        /**
         * A label to use for the button group (for assistive devices only).
         */
        public ?string $label = null,

        /**
         * The orientation of the button group.
         */
        public ButtonGroupOrientation $orientation = ButtonGroupOrientation::Horizontal,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'ButtonGroup.php';
    }
}
