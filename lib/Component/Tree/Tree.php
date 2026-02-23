<?php

namespace Yakamara\Roadie\Component\Tree;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Tree/templates/Tree.php
 */
/**
 * @summary Trees allow you to display a hierarchical list of selectable tree items.
 * @status stable
 * @since 1.0
 *
 * @slot - One or more <wa-tree-item> elements.
 * @slot expand-icon   - The icon to show when expanded.
 * @slot collapse-icon - The icon to show when collapsed.
 */
final class Tree extends Component
{
    public function __construct(
        /**
         * One or more tree items.
         *
         * @var list<TreeItem>
         */
        public array $items,

        /**
         * The selection behavior of the tree.
         */
        public TreeSelection $selection = TreeSelection::Single,

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
        return 'Tree.php';
    }
}
