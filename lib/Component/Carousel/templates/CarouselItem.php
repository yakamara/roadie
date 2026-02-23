<?php

use Yakamara\Roadie\Component\Carousel\CarouselItem;
use Yakamara\Roadie\Component\Component;

/** @var CarouselItem $this */
?>

<wa-carousel-item <?= $this->attributes->toString() ?>>
    <?= Component::slot($this->content) ?>
</wa-carousel-item>
