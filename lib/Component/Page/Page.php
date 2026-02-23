<?php

namespace Yakamara\Roadie\Component\Page;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Page/templates/Page.php
 */
/**
 * @summary The page component provides a standard app shell layout with header, navigation, content, and footer areas.
 * @status stable
 * @since 1.0
 *
 * @slot                   - Main page content.
 * @slot banner            - Content above the header; hidden if empty.
 * @slot header            - Top-level navigation/branding area.
 * @slot subheader         - Below the header; ideal for breadcrumbs.
 * @slot navigation        - Left-side navigation; collapses to drawer on mobile.
 * @slot navigation-header - Navigation area header.
 * @slot navigation-footer - Navigation area footer.
 * @slot navigation-toggle - Custom toggle button for the navigation drawer.
 * @slot navigation-toggle-icon - Custom icon inside the toggle button.
 * @slot main-header       - Inline header above main content.
 * @slot main-footer       - Inline footer below main content.
 * @slot aside             - Right-side supplementary content (e.g. TOC, ads).
 * @slot footer            - Page footer; always below viewport.
 * @slot skip-to-content   - "Skip to content" link text.
 */
final class Page extends Component
{
    public function __construct(
        /**
         * Main page content.
         */
        public string|Component|null $content = null,

        /**
         * Viewport width at which navigation collapses to a drawer.
         */
        public ?string $mobileBreakpoint = null,

        /**
         * Mobile drawer position.
         */
        public PageNavigationPlacement $navigationPlacement = PageNavigationPlacement::Start,

        /**
         * Whether the mobile navigation drawer is open.
         */
        public bool $navOpen = false,

        /**
         * Hides the default hamburger button.
         */
        public bool $disableNavigationToggle = false,

        /**
         * Content above the header; hidden if empty.
         */
        public string|Component|null $banner = null,

        /**
         * Top-level navigation/branding area.
         */
        public string|Component|null $header = null,

        /**
         * Below the header; ideal for breadcrumbs.
         */
        public string|Component|null $subheader = null,

        /**
         * Left-side navigation.
         */
        public string|Component|null $navigation = null,

        /**
         * Navigation area header.
         */
        public string|Component|null $navigationHeader = null,

        /**
         * Navigation area footer.
         */
        public string|Component|null $navigationFooter = null,

        /**
         * Custom toggle button for the navigation drawer.
         */
        public string|Component|null $navigationToggle = null,

        /**
         * Custom icon inside the toggle button.
         */
        public string|Component|null $navigationToggleIcon = null,

        /**
         * Inline header above main content.
         */
        public string|Component|null $mainHeader = null,

        /**
         * Inline footer below main content.
         */
        public string|Component|null $mainFooter = null,

        /**
         * Right-side supplementary content.
         */
        public string|Component|null $aside = null,

        /**
         * Page footer; always below viewport.
         */
        public string|Component|null $footer = null,

        /**
         * "Skip to content" link text.
         */
        public string|Component|null $skipToContent = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Page.php';
    }
}
