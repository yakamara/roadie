<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\ProgressRing\ProgressRing;

/** @var ProgressRing $this */
?>

<wa-progress-ring <?= $this->attributes->with([
    'value' => $this->value,
    'label' => $this->label,
])->toString() ?>><?= Component::slot($this->indicator) ?></wa-progress-ring>
