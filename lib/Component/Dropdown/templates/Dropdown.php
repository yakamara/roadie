<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Dropdown\Dropdown;
use Yakamara\Roadie\Component\Dropdown\DropdownPlacement;
use Yakamara\Roadie\Component\Dropdown\DropdownSize;

/** @var Dropdown $this */
?>

<wa-dropdown <?= $this->attributes->with([
    'placement' => $this->placement !== DropdownPlacement::BottomStart ? $this->placement : null,
    'size' => $this->size !== DropdownSize::Medium ? $this->size : null,
    'open' => $this->open,
    'distance' => $this->distance !== 0 ? $this->distance : null,
    'skidding' => $this->skidding !== 0 ? $this->skidding : null,
])->toString() ?>>
    <?= Component::slot($this->trigger, 'trigger') ?>
    <?php foreach ($this->items as $item): ?>
        <?= $item ?>
    <?php endforeach ?>
</wa-dropdown>
