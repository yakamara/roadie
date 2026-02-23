<?php

use Yakamara\Roadie\Component\Carousel\Carousel;
use Yakamara\Roadie\Component\Carousel\CarouselOrientation;
use Yakamara\Roadie\Component\Component;

/** @var Carousel $this */
?>

<wa-carousel <?= $this->attributes->with([
    'orientation' => $this->orientation !== CarouselOrientation::Horizontal ? $this->orientation : null,
    'slides-per-page' => $this->slidesPerPage !== 1 ? $this->slidesPerPage : null,
    'slides-per-move' => $this->slidesPerMove !== 1 ? $this->slidesPerMove : null,
    'navigation' => $this->navigation,
    'pagination' => $this->pagination,
    'loop' => $this->loop,
    'mouse-dragging' => $this->mouseDragging,
    'autoplay' => $this->autoplay,
    'autoplay-interval' => $this->autoplayInterval !== 3000 ? $this->autoplayInterval : null,
])->toString() ?>>
    <?= Component::slot($this->previousIcon, 'previous-icon') ?>
    <?= Component::slot($this->nextIcon, 'next-icon') ?>
    <?php foreach ($this->items as $item): ?>
        <?= $item ?>
    <?php endforeach ?>
</wa-carousel>
