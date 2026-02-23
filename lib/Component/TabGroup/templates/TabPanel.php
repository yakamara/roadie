<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\TabGroup\TabPanel;

/** @var TabPanel $this */
?>

<wa-tab-panel <?= $this->attributes->with([
    'name' => $this->name ?: null,
    'active' => $this->active,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-tab-panel>
