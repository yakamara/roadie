<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Tooltip\Tooltip;
use Yakamara\Roadie\Component\Tooltip\TooltipPlacement;

/** @var Tooltip $this */
?>

<wa-tooltip <?= $this->attributes->with([
    'for' => $this->targetId,
    'placement' => $this->placement !== TooltipPlacement::Top ? $this->placement : null,
    'trigger' => $this->trigger !== 'hover focus' ? $this->trigger : null,
    'distance' => $this->distance !== 8 ? $this->distance : null,
    'skidding' => $this->skidding ?: null,
    'show-delay' => $this->showDelay !== 150 ? $this->showDelay : null,
    'hide-delay' => $this->hideDelay ?: null,
    'open' => $this->open,
    'disabled' => $this->disabled,
    'without-arrow' => $this->withoutArrow,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-tooltip>
