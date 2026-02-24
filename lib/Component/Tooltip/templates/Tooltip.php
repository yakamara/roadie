<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Tooltip\Tooltip;
use Yakamara\Roadie\Component\Tooltip\TooltipPlacement;

/** @var Tooltip $this */
?>

<wa-tooltip <?= $this->attributes->with([
    'for' => $this->targetId,
    'placement' => TooltipPlacement::Top !== $this->placement ? $this->placement : null,
    'trigger' => 'hover focus' !== $this->trigger ? $this->trigger : null,
    'distance' => 8 !== $this->distance ? $this->distance : null,
    'skidding' => $this->skidding ?: null,
    'show-delay' => 150 !== $this->showDelay ? $this->showDelay : null,
    'hide-delay' => $this->hideDelay ?: null,
    'open' => $this->open,
    'disabled' => $this->disabled,
    'without-arrow' => $this->withoutArrow,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-tooltip>
