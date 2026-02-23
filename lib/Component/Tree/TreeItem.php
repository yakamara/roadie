<?php

namespace Yakamara\Roadie\Component\Tree;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Tree/templates/TreeItem.php
 */
/**
 * @summary A tree item serves as a hierarchical node that lives inside a tree.
 * @status stable
 * @since 1.0
 *
 * @slot - The tree item's label.
 * @slot expand-icon   - The icon shown when expanded.
 * @slot collapse-icon - The icon shown when collapsed.
 */
final class TreeItem extends Component
{
    public function __construct(
        /**
         * The tree item's label.
         */
        public string|Component $label,

        /**
         * Child tree items.
         *
         * @var list<TreeItem>
         */
        public array $children = [],

        /**
         * Expands the tree item.
         */
        public bool $expanded = false,

        /**
         * Selects the tree item.
         */
        public bool $selected = false,

        /**
         * Disables the tree item.
         */
        public bool $disabled = false,

        /**
         * Marks the tree item as lazy-loaded (shows expand indicator even without children).
         */
        public bool $lazy = false,

        /**
         * Custom expand icon.
         */
        public string|Component|null $expandIcon = null,

        /**
         * Custom collapse icon.
         */
        public string|Component|null $collapseIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'TreeItem.php';
    }
}
