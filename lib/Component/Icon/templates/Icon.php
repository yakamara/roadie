<?php

use Yakamara\Roadie\Component\Icon\Icon;

/** @var Icon $this */
?>

<wa-icon <?= $this->attributes->with([
    'name' => $this->name,
    'src' => $this->src,
    'library' => $this->library,
    'family' => $this->family,
    'variant' => $this->variant,
    'label' => $this->label ?: null,
    'animation' => $this->animation,
    'flip' => $this->flip,
    'rotate' => $this->rotate ?: null,
    'swap-opacity' => $this->swapOpacity,
    'auto-width' => $this->autoWidth,
    'aria-hidden' => null === $this->label ? 'true' : null,
])->toString() ?>></wa-icon>
