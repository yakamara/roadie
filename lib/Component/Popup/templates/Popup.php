<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Popup\Popup;
use Yakamara\Roadie\Component\Popup\PopupArrowPlacement;
use Yakamara\Roadie\Component\Popup\PopupBoundary;
use Yakamara\Roadie\Component\Popup\PopupFlipFallbackStrategy;
use Yakamara\Roadie\Component\Popup\PopupPlacement;

/** @var Popup $this */
?>

<wa-popup <?= $this->attributes->with([
    'anchor' => $this->anchor,
    'active' => $this->active,
    'placement' => PopupPlacement::Top !== $this->placement ? $this->placement : null,
    'distance' => 0 !== $this->distance ? $this->distance : null,
    'skidding' => 0 !== $this->skidding ? $this->skidding : null,
    'arrow' => $this->arrow,
    'arrow-padding' => 10 !== $this->arrowPadding ? $this->arrowPadding : null,
    'arrow-placement' => PopupArrowPlacement::Anchor !== $this->arrowPlacement ? $this->arrowPlacement : null,
    'auto-size' => $this->autoSize,
    'auto-size-padding' => 0 !== $this->autoSizePadding ? $this->autoSizePadding : null,
    'boundary' => PopupBoundary::Viewport !== $this->boundary ? $this->boundary : null,
    'flip' => $this->flip,
    'flip-fallback-placements' => $this->flipFallbackPlacements,
    'flip-fallback-strategy' => PopupFlipFallbackStrategy::BestFit !== $this->flipFallbackStrategy ? $this->flipFallbackStrategy : null,
    'flip-padding' => 0 !== $this->flipPadding ? $this->flipPadding : null,
    'shift' => $this->shift,
    'shift-padding' => 0 !== $this->shiftPadding ? $this->shiftPadding : null,
    'sync' => $this->sync,
    'hover-bridge' => $this->hoverBridge,
])->toString() ?>>
    <?= Component::slot($this->anchorSlot, 'anchor') ?>
    <?= Component::slot($this->content) ?>
</wa-popup>
