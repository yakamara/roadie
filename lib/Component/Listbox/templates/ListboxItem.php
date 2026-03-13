<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Listbox\ListboxItem;

/** @var ListboxItem $this */
?>

<<?= $this->href ? 'a' : 'span'?> <?= $this->attributes->with([
    'class' => 'roadie-listbox--item',
    'href' => $this->href,
    'role' => $this->href ? 'option' : null,
    'aria-selected' => $this->href ? ($this->selected ? 'true' : 'false') : null,
])->toString() ?>>
    <?= Component::slot($this->start, 'start') ?>
    <span class="roadie-listbox--item-label"><?= Component::slot($this->label) ?></span>
    <?= Component::slot($this->end, 'end') ?>
</<?= $this->href ? 'a' : 'span'?>>
