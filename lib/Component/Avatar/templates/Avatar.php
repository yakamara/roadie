<?php

use Yakamara\Roadie\Component\Avatar\Avatar;
use Yakamara\Roadie\Component\Avatar\AvatarLoading;
use Yakamara\Roadie\Component\Avatar\AvatarShape;
use Yakamara\Roadie\Component\Component;

/** @var Avatar $this */
?>

<wa-avatar <?= $this->attributes->with([
    'label' => $this->label,
    'image' => $this->image,
    'initials' => $this->initials,
    'shape' => $this->shape !== AvatarShape::Circle ? $this->shape : null,
    'loading' => $this->loading !== AvatarLoading::Eager ? $this->loading : null,
])->toString() ?>>
    <?= Component::slot($this->icon, 'icon') ?>
</wa-avatar>
