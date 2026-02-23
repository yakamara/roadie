<?php

namespace Yakamara\Roadie\Component\Avatar;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Avatar/templates/Avatar.php
 */
/**
 * @summary Avatars are used to represent a person or object.
 * @status stable
 * @since 1.0
 *
 * @slot icon - The default icon to use when no image or initials are present. Works best with <wa-icon>.
 */
final class Avatar extends Component
{
    public function __construct(
        /**
         * A label to describe the avatar to assistive devices.
         */
        public ?string $label = null,

        /**
         * The image source to use for the avatar.
         */
        public ?string $image = null,

        /**
         * Initials to use as a fallback when no image is available (1–2 characters recommended).
         */
        public ?string $initials = null,

        /**
         * The shape of the avatar.
         */
        public AvatarShape $shape = AvatarShape::Circle,

        /**
         * Indicates how the browser should load the image.
         */
        public AvatarLoading $loading = AvatarLoading::Eager,

        /**
         * The default icon to use when no image or initials are present.
         * Works best with <wa-icon>.
         */
        public string|Component|null $icon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Avatar.php';
    }
}
