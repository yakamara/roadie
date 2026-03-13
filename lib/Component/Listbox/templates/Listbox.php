<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Listbox\Listbox;
use Yakamara\Roadie\Component\Listbox\ListboxPlacement;
use Yakamara\Roadie\Util\Aria;

/** @var Listbox $this */

$menuId = Aria::id();
?>
<div <?= $this->attributes->with([
    'class' => 'roadie-listbox',
    'data-component' => 'listbox',
    'data-placement' => ListboxPlacement::BottomEnd !== $this->placement ? $this->placement : null,
])->toString() ?>>
    <button <?= (new HtmlAttributes([
        'class' => [
            'roadie-listbox--trigger',
            'wa-' . $this->appearance->value,
            'wa-' . $this->variant->value
        ],
        'data-target' => 'listbox.trigger',
        'data-action' => 'click:toggle keydown:onTriggerKey',
        'aria-haspopup' => 'listbox',
        'aria-expanded' => 'false',
        'aria-controls' => $menuId,
    ])) ?>>
        <?= $this->start ?>
        <span data-target="listbox.display">
            <?= $this->trigger ?>
        </span>
        <?= $this->end ?>
    </button>
    <ul <?= (new HtmlAttributes([
        'class' => 'roadie-listbox--list',
        'id' => $menuId,
        'data-target' => 'listbox.menu',
        'role' => 'listbox',
        'aria-label' => $this->label,
    ])) ?>>
        <?php foreach ($this->items as $item): ?>
            <li <?= (new HtmlAttributes([
                'role' => null === $item->href ? 'option' : null,
                'aria-selected' => null === $item->href ? ($item->selected ? 'true' : 'false') : null,
                'data-value' => $item->value,
            ])) ?>>
                <?= $item ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
