<?php

use Yakamara\Roadie\Component\Button\Button;
use Yakamara\Roadie\Component\Component;

/** @var Button $this */
?>

<wa-button <?= $this->attributes->with([
    'appearance' => $this->appearance,
    'variant' => $this->variant,
    'size' => $this->size,
    'with-caret' => $this->withCaret,
    'loading' => $this->loading,
    'disabled' => $this->disabled,
    'pill' => $this->pill,
    'type' => $this->type,
    'name' => $this->name,
    'value' => $this->value,
    'href' => $this->href,
    'target' => $this->target,
    'rel' => $this->href && $this->rel !== 'noreferrer noopener' ? $this->rel : null,
    'download' => $this->download,
    'form-action' => $this->formAction,
    'form-enctype' => $this->formEnctype,
    'form-method' => $this->formMethod,
    'form-novalidate' => $this->formNoValidate,
    'form-target' => $this->formTarget,
])->toString() ?>>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->label) ?>
</wa-button>
