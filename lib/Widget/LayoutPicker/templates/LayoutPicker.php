<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Widget\LayoutPicker\LayoutPicker;

/** @var LayoutPicker $this */
?>

<wa-radio-group <?= $this->attributes->with([
    'class' => 'layout-picker',
    'label' => is_string($this->label) ? $this->label : null,
    'hint' => is_string($this->hint) ? $this->hint : null,
    'name' => $this->name,
    'value' => $this->value,
    'required' => $this->required,
    'with-label' => null !== $this->label,
    'with-hint' => null !== $this->hint,
    'orientation' => 'horizontal',
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?php foreach ($this->options as $option): ?>
        <wa-radio
            value="<?= rex_escape($option->value) ?>"
            appearance="button"
            <?= $option->disabled ? 'disabled' : '' ?>
        >
            <span class="layout-picker--option">
                <?= $option->svg ?>
                <?php if ($option->label): ?>
                    <span class="layout-picker--label"><?= rex_escape($option->label) ?></span>
                <?php endif ?>
            </span>
        </wa-radio>
    <?php endforeach ?>
</wa-radio-group>
