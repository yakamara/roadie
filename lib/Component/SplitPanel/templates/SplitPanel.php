<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\SplitPanel\SplitPanel;
use Yakamara\Roadie\Component\SplitPanel\SplitPanelOrientation;

/** @var SplitPanel $this */
?>

<wa-split-panel <?= $this->attributes->with([
    'position' => $this->position !== 50 ? $this->position : null,
    'position-in-pixels' => $this->positionInPixels,
    'orientation' => $this->orientation !== SplitPanelOrientation::Horizontal ? $this->orientation : null,
    'primary' => $this->primary,
    'snap' => $this->snap,
    'snap-threshold' => $this->snapThreshold !== 12 ? $this->snapThreshold : null,
    'disabled' => $this->disabled,
])->toString() ?>>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->divider, 'divider') ?>
</wa-split-panel>
