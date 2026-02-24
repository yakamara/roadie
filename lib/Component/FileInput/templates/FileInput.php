<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\FileInput\FileInput;
use Yakamara\Roadie\Component\FileInput\FileInputSize;

/** @var FileInput $this */
?>

<wa-file-input <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'accept' => $this->accept,
    'multiple' => $this->multiple,
    'required' => $this->required,
    'size' => FileInputSize::Medium !== $this->size ? $this->size : null,
    'hint' => $this->hint ?: null,
    'with-label' => null !== $this->label,
    'with-hint' => null !== $this->hint,
])->toString() ?>>
    <?= $this->label instanceof Component ? Component::slot($this->label, 'label') : '' ?>
    <?= $this->hint instanceof Component ? Component::slot($this->hint, 'hint') : '' ?>
    <?= Component::slot($this->dropzone, 'dropzone') ?>
    <?= Component::slot($this->fileIcon, 'file-icon') ?>
</wa-file-input>
