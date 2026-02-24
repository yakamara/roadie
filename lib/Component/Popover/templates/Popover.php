<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Popover\Popover;
use Yakamara\Roadie\Component\Popover\PopoverPlacement;

/** @var Popover $this */
?>

<wa-popover <?= $this->attributes->with([
    'for' => $this->targetId,
    'open' => $this->open,
    'placement' => PopoverPlacement::Top !== $this->placement ? $this->placement : null,
    'distance' => 8 !== $this->distance ? $this->distance : null,
    'skidding' => 0 !== $this->skidding ? $this->skidding : null,
    'without-arrow' => $this->withoutArrow,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-popover>
