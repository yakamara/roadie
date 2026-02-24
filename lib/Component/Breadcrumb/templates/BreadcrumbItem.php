<?php

use Yakamara\Roadie\Component\Breadcrumb\BreadcrumbItem;
use Yakamara\Roadie\Component\Component;

/** @var BreadcrumbItem $this */
?>

<wa-breadcrumb-item <?= $this->attributes->with([
    'href' => $this->href,
    'target' => $this->target,
    'rel' => $this->href && 'noreferrer noopener' !== $this->rel ? $this->rel : null,
])->toString() ?>>
    <?= Component::slot($this->start, 'start') ?>
    <?= Component::slot($this->end, 'end') ?>
    <?= Component::slot($this->separator, 'separator') ?>
    <?= Component::slot($this->label) ?>
</wa-breadcrumb-item>
