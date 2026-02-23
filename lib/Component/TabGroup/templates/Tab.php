<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\TabGroup\Tab;

/** @var Tab $this */
?>

<wa-tab <?= $this->attributes->with([
    'panel' => $this->panel ?: null,
    'disabled' => $this->disabled,
])->toString() ?>>
    <?= Component::slot($this->label) ?>
</wa-tab>
