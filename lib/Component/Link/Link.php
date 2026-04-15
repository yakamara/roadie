<?php

namespace Yakamara\Roadie\Component\Link;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Link/templates/Link.php
 */
/**
 * @summary Links represent actions that are available to the user.
 * @status experimental
 * @since 1.0
 *
 * @slot - The link label.
 * @slot prefix - A presentational prefix icon or similar element.
 * @slot suffix - A presentational suffix icon or similar element.
 */
final class Link extends Component
{
    public function __construct(
        /**
         * The button's label.
         */
        public string|Component $label,

        /**
         * A presentational start icon or similar element.
         */
        public string|Component|null $start = null,

        /**
         * A presentational end icon or similar element.
         */
        public string|Component|null $end = null,

        /**
         * When set, the underlying button will be rendered
         * as an <a> with this href instead of a <button>.
         */
        public ?string $href = null,

        /**
         * Tells the browser where to open the link. Only
         * used when href is present.
         */
        public ?LinkTarget $target = null,

        /**
         * When using `href`, this attribute will map to the underlying link's `rel` attribute. Unlike regular links, the
         * default is `noreferrer noopener` to prevent security exploits. However, if you're using `target` to point to a
         * specific tab/window, this will prevent that from working correctly. You can remove or change the default value by
         * setting the attribute to an empty string or a value of your choice, respectively.
         */
        public ?string $rel = 'noreferrer noopener',

        /**
         * The type of link.
         */
        public LinkType $type = LinkType::Internal,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    public function render(): string
    {
        if (null === $this->href) {
            $this->href = $this->label;
        }

        $this->href = $this->type->getHref($this->href);

        if (null === $this->target) {
            $this->rel = null;
        }

        $this->attributes->with($this->type->getAttributes());

        return parent::render();
    }

    protected function getPath(): string
    {
        return 'Link.php';
    }
}
