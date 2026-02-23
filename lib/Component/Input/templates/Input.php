<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Input\Input;
use Yakamara\Roadie\Component\Input\InputAppearance;
use Yakamara\Roadie\Component\Input\InputSize;
use Yakamara\Roadie\Component\Input\InputType;

/** @var Input $this */
?>

<wa-input <?= $this->attributes->with([
    'type' => $this->type !== InputType::Text ? $this->type : null,
    'label' => $this->label ?: null,
    'value' => $this->value,
    'default-value' => $this->defaultValue,
    'placeholder' => $this->placeholder ?: null,
    'size' => $this->size !== InputSize::Medium ? $this->size : null,
    'appearance' => $this->appearance !== InputAppearance::Outlined ? $this->appearance : null,
    'name' => $this->name,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
    'required' => $this->required,
    'pill' => $this->pill,
    'password-toggle' => $this->passwordToggle,
    'password-visible' => $this->passwordVisible,
    'without-spin-buttons' => $this->withoutSpinButtons,
    'hint' => $this->hint ?: null,
    'minlength' => $this->minlength,
    'maxlength' => $this->maxlength,
    'min' => $this->min,
    'max' => $this->max,
    'step' => $this->step,
    'pattern' => $this->pattern,
    'autocomplete' => $this->autocomplete,
    'autocapitalize' => $this->autocapitalize,
    'autocorrect' => $this->autocorrect,
    'spellcheck' => $this->spellcheck !== null ? ($this->spellcheck ? 'true' : 'false') : null,
    'autofocus' => $this->autofocus,
    'enterkeyhint' => $this->enterkeyhint,
    'inputmode' => $this->inputmode ?? $this->type->toInputmode(),
    'with-clear' => $this->withClear,
    'with-hint' => $this->hint !== null,
    'with-label' => $this->label !== null,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->clearIcon, 'clear-icon') ?>
    <?= Component::slot($this->showPasswordIcon, 'show-password-icon') ?>
    <?= Component::slot($this->hidePasswordIcon, 'hide-password-icon') ?>
</wa-input>
