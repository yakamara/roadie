<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Scroller\Scroller;
use Yakamara\Roadie\Component\Scroller\ScrollerOrientation;

/** @var Scroller $this */
?>

<wa-scroller <?= $this->attributes->with([
    'orientation' => ScrollerOrientation::Horizontal !== $this->orientation ? $this->orientation : null,
    'without-scrollbar' => $this->withoutScrollbar,
    'without-shadow' => $this->withoutShadow,
])->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-scroller>
