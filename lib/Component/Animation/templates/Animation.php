<?php

use Yakamara\Roadie\Component\Animation\Animation;
use Yakamara\Roadie\Component\Animation\AnimationDirection;
use Yakamara\Roadie\Component\Animation\AnimationFill;
use Yakamara\Roadie\Component\Component;

/** @var Animation $this */
?>

<wa-animation <?= $this->attributes->with([
    'name' => $this->name,
    'play' => $this->play,
    'duration' => 1000 !== $this->duration ? $this->duration : null,
    'delay' => 0 !== $this->delay ? $this->delay : null,
    'end-delay' => 0 !== $this->endDelay ? $this->endDelay : null,
    'easing' => $this->easing,
    'iterations' => $this->iterations,
    'iteration-start' => 0.0 !== $this->iterationStart ? $this->iterationStart : null,
    'direction' => AnimationDirection::Normal !== $this->direction ? $this->direction : null,
    'fill' => AnimationFill::Auto !== $this->fill ? $this->fill : null,
    'playback-rate' => 1.0 !== $this->playbackRate ? $this->playbackRate : null,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-animation>
