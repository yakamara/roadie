<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\TabGroup\Tab;

/** @var Tab $this */
?>

<wa-tab <?= $this->tabAttributes->with([
    'panel' => $this->name ?: null,
    'disabled' => $this->disabled,
])->toString() ?>>
    <?= Component::slot($this->label) ?>
</wa-tab>
<wa-tab-panel <?= $this->panelAttributes->with([
    'name' => $this->name,
    'active' => $this->active,
]) ?>>
    <?= Component::slot($this->panel) ?>
</wa-tab-panel>