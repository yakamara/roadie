<?php

namespace Yakamara\Roadie\Component\Card;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Card/templates/Card.php
 */
/**
 * @summary Cards can be used to group related subjects in a container.
 * @status stable
 * @since 1.0
 *
 * @slot - The card's main content.
 * @slot header - An optional header for the card.
 * @slot header-actions - An optional actions area in the header (vertical cards only).
 * @slot footer - An optional footer for the card.
 * @slot footer-actions - An optional actions area in the footer (vertical cards only).
 * @slot media - An optional media section at the start of the card.
 * @slot actions - An optional actions area at the end (horizontal cards only).
 */
final class Card extends Component
{
    public function __construct(
        /**
         * The card's main content.
         */
        public string|Component $content,

        /**
         * An optional header for the card.
         */
        public string|Component|null $header = null,

        /**
         * An optional actions area in the header (vertical cards only).
         */
        public string|Component|null $headerActions = null,

        /**
         * An optional footer for the card.
         */
        public string|Component|null $footer = null,

        /**
         * An optional actions area in the footer (vertical cards only).
         */
        public string|Component|null $footerActions = null,

        /**
         * An optional media section at the start of the card.
         */
        public string|Component|null $media = null,

        /**
         * An optional actions area at the end (horizontal cards only).
         */
        public string|Component|null $actions = null,

        /**
         * The card's visual appearance.
         */
        public CardAppearance $appearance = CardAppearance::Outlined,

        /**
         * The card's orientation.
         */
        public CardOrientation $orientation = CardOrientation::Vertical,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Card.php';
    }
}
