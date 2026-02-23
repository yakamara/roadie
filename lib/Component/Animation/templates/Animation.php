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
    'duration' => $this->duration !== 1000 ? $this->duration : null,
    'delay' => $this->delay !== 0 ? $this->delay : null,
    'end-delay' => $this->endDelay !== 0 ? $this->endDelay : null,
    'easing' => $this->easing,
    'iterations' => $this->iterations,
    'iteration-start' => $this->iterationStart !== 0.0 ? $this->iterationStart : null,
    'direction' => $this->direction !== AnimationDirection::Normal ? $this->direction : null,
    'fill' => $this->fill !== AnimationFill::Auto ? $this->fill : null,
    'playback-rate' => $this->playbackRate !== 1.0 ? $this->playbackRate : null,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-animation>
