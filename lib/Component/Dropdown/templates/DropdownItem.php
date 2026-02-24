<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Dropdown\DropdownItem;
use Yakamara\Roadie\Component\Dropdown\DropdownItemType;
use Yakamara\Roadie\Component\Dropdown\DropdownItemVariant;

/** @var DropdownItem $this */
?>

<wa-dropdown-item <?= $this->attributes->with([
    'value' => $this->value,
    'type' => DropdownItemType::Normal !== $this->type ? $this->type : null,
    'variant' => DropdownItemVariant::Default !== $this->variant ? $this->variant : null,
    'checked' => $this->checked,
    'disabled' => $this->disabled,
])->toString() ?>>
    <?= Component::slot($this->icon, 'icon') ?>
    <?= Component::slot($this->details, 'details') ?>
    <?= Component::slot($this->submenu, 'submenu') ?>
    <?= Component::slot($this->label) ?>
</wa-dropdown-item>
