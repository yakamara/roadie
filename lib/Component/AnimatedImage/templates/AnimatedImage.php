<?php

use Yakamara\Roadie\Component\AnimatedImage\AnimatedImage;
use Yakamara\Roadie\Component\Component;

/** @var AnimatedImage $this */
?>

<wa-animated-image <?= $this->attributes->with([
    'src' => $this->src,
    'alt' => $this->alt,
    'play' => $this->play,
])->toString() ?>>
    <?= Component::slot($this->playIcon, 'play-icon') ?>
    <?= Component::slot($this->pauseIcon, 'pause-icon') ?>
</wa-animated-image>
