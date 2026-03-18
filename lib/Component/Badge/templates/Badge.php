<?php

use Yakamara\Roadie\Component\Badge\Badge;
use Yakamara\Roadie\Component\Badge\BadgeAttention;
use Yakamara\Roadie\Component\Component;

/** @var Badge $this */
?>

<wa-badge <?= $this->attributes->with([
    'appearance' => $this->appearance,
    'variant' => $this->variant,
    'attention' => BadgeAttention::None !== $this->attention ? $this->attention : null,
    'pill' => $this->pill,
])->toString() ?>><?= Component::slot($this->content) ?></wa-badge>
