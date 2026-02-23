<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\ZoomableFrame\ZoomableFrame;
use Yakamara\Roadie\Component\ZoomableFrame\ZoomableFrameLoading;

/** @var ZoomableFrame $this */
?>

<wa-zoomable-frame <?= $this->attributes->with([
    'src' => $this->src,
    'srcdoc' => $this->srcdoc,
    'loading' => $this->loading !== ZoomableFrameLoading::Eager ? $this->loading : null,
    'allowfullscreen' => $this->allowfullscreen,
    'sandbox' => $this->sandbox,
    'referrerpolicy' => $this->referrerpolicy,
    'without-controls' => $this->withoutControls,
    'without-interaction' => $this->withoutInteraction,
    'zoom' => $this->zoom !== 1.0 ? $this->zoom : null,
    'zoom-levels' => $this->zoomLevels,
])->toString() ?>>
    <?= Component::slot($this->zoomInIcon, 'zoom-in-icon') ?>
    <?= Component::slot($this->zoomOutIcon, 'zoom-out-icon') ?>
</wa-zoomable-frame>
