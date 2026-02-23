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
    'placement' => $this->placement !== PopupPlacement::Top ? $this->placement : null,
    'distance' => $this->distance !== 0 ? $this->distance : null,
    'skidding' => $this->skidding !== 0 ? $this->skidding : null,
    'arrow' => $this->arrow,
    'arrow-padding' => $this->arrowPadding !== 10 ? $this->arrowPadding : null,
    'arrow-placement' => $this->arrowPlacement !== PopupArrowPlacement::Anchor ? $this->arrowPlacement : null,
    'auto-size' => $this->autoSize,
    'auto-size-padding' => $this->autoSizePadding !== 0 ? $this->autoSizePadding : null,
    'boundary' => $this->boundary !== PopupBoundary::Viewport ? $this->boundary : null,
    'flip' => $this->flip,
    'flip-fallback-placements' => $this->flipFallbackPlacements,
    'flip-fallback-strategy' => $this->flipFallbackStrategy !== PopupFlipFallbackStrategy::BestFit ? $this->flipFallbackStrategy : null,
    'flip-padding' => $this->flipPadding !== 0 ? $this->flipPadding : null,
    'shift' => $this->shift,
    'shift-padding' => $this->shiftPadding !== 0 ? $this->shiftPadding : null,
    'sync' => $this->sync,
    'hover-bridge' => $this->hoverBridge,
])->toString() ?>>
    <?= Component::slot($this->anchorSlot, 'anchor') ?>
    <?= Component::slot($this->content) ?>
</wa-popup>
