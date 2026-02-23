<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Textarea\Textarea;
use Yakamara\Roadie\Component\Textarea\TextareaAppearance;
use Yakamara\Roadie\Component\Textarea\TextareaResize;
use Yakamara\Roadie\Component\Textarea\TextareaSize;

/** @var Textarea $this */
?>

<wa-textarea <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'value' => $this->value,
    'default-value' => $this->defaultValue,
    'placeholder' => $this->placeholder ?: null,
    'size' => $this->size !== TextareaSize::Medium ? $this->size : null,
    'appearance' => $this->appearance !== TextareaAppearance::Outlined ? $this->appearance : null,
    'name' => $this->name,
    'disabled' => $this->disabled,
    'readonly' => $this->readonly,
    'required' => $this->required,
    'rows' => $this->rows !== 4 ? $this->rows : null,
    'resize' => $this->resize !== TextareaResize::Vertical ? $this->resize : null,
    'hint' => $this->hint ?: null,
    'minlength' => $this->minlength,
    'maxlength' => $this->maxlength,
    'autocomplete' => $this->autocomplete,
    'autocapitalize' => $this->autocapitalize,
    'autocorrect' => $this->autocorrect,
    'spellcheck' => $this->spellcheck !== null ? ($this->spellcheck ? 'true' : 'false') : null,
    'autofocus' => $this->autofocus,
    'enterkeyhint' => $this->enterkeyhint,
    'inputmode' => $this->inputmode,
    'with-label' => $this->label !== null,
    'with-hint' => $this->hint !== null,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
</wa-textarea>
