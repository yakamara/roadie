<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\ProgressBar\ProgressBar;

/** @var ProgressBar $this */
?>

<wa-progress-bar <?= $this->attributes->with([
    'value' => $this->value,
    'indeterminate' => $this->indeterminate,
    'label' => $this->label,
])->toString() ?>>
    <?= Component::slot($this->indicator) ?>
</wa-progress-bar>
