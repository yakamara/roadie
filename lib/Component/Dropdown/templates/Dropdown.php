<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Dropdown\Dropdown;
use Yakamara\Roadie\Component\Dropdown\DropdownPlacement;
use Yakamara\Roadie\Component\Dropdown\DropdownSize;

/** @var Dropdown $this */
?>

<wa-dropdown <?= $this->attributes->with([
    'placement' => DropdownPlacement::BottomStart !== $this->placement ? $this->placement : null,
    'size' => DropdownSize::Medium !== $this->size ? $this->size : null,
    'open' => $this->open,
    'distance' => 0 !== $this->distance ? $this->distance : null,
    'skidding' => 0 !== $this->skidding ? $this->skidding : null,
])->toString() ?>>
    <?= Component::slot($this->trigger, 'trigger') ?>
    <?php foreach ($this->items as $item): ?>
        <?= $item instanceof Component ? $item->render() : $item ?>
    <?php endforeach ?>
</wa-dropdown>
