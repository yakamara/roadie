<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Popover\Popover;
use Yakamara\Roadie\Component\Popover\PopoverPlacement;

/** @var Popover $this */
?>

<wa-popover <?= $this->attributes->with([
    'for' => $this->targetId,
    'open' => $this->open,
    'placement' => $this->placement !== PopoverPlacement::Top ? $this->placement : null,
    'distance' => $this->distance !== 8 ? $this->distance : null,
    'skidding' => $this->skidding !== 0 ? $this->skidding : null,
    'without-arrow' => $this->withoutArrow,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-popover>
