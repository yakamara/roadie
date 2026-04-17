<?php

namespace Yakamara\Roadie\Component\Icon;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Icons\IconRegistry;

/**
 * @see src/addons/roadie/lib/Component/Icon/templates/Icon.php
 */
/**
 * @summary Icons are symbols that can be used to represent various options within an application.
 * @status stable
 * @since 1.0
 */
final class Icon extends Component
{
    public function __construct(
        /**
         * The name of the icon to draw. Available icons depend on the icon library being used.
         */
        public ?string $name = null,

        /**
         * An external URL of an SVG file. Be sure you trust the content you are including,
         * as it will be executed as code and can result in XSS attacks.
         */
        public ?string $src = null,

        /**
         * The icon library to use. Defaults to the built-in library.
         */
        public ?string $library = null,

        /**
         * The icon family to use, e.g. "classic", "brands", "sharp", "duotone".
         */
        public ?IconFamily $family = null,

        /**
         * The icon variant to use, e.g. "thin", "light", "regular", "solid".
         */
        public ?IconVariant $variant = null,

        /**
         * A description that gets read by assistive devices. If omitted, the icon
         * will be considered presentational and ignored by assistive devices.
         */
        public ?string $label = null,

        /**
         * Sets the animation for the icon.
         */
        public ?IconAnimation $animation = null,

        /**
         * Flips the icon along the specified axis.
         */
        public ?IconFlip $flip = null,

        /**
         * Sets the rotation of the icon in degrees.
         */
        public ?int $rotate = null,

        /**
         * Swaps the opacity of duotone icons.
         */
        public bool $swapOpacity = false,

        /**
         * Sets the width of the icon to match the cropped SVG viewBox.
         */
        public bool $autoWidth = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {
        if (null !== $this->name) {
            $resolved = IconRegistry::resolveAlias($this->name);
            $this->name = $resolved['name'];
            if (null === $this->library && null !== $resolved['library']) {
                $this->library = $resolved['library'];
            }
        }
    }

    protected function getPath(): string
    {
        return 'Icon.php';
    }
}
