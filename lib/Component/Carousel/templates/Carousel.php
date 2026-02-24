<?php

use Yakamara\Roadie\Component\Carousel\Carousel;
use Yakamara\Roadie\Component\Carousel\CarouselOrientation;
use Yakamara\Roadie\Component\Component;

/** @var Carousel $this */
?>

<wa-carousel <?= $this->attributes->with([
    'orientation' => CarouselOrientation::Horizontal !== $this->orientation ? $this->orientation : null,
    'slides-per-page' => 1 !== $this->slidesPerPage ? $this->slidesPerPage : null,
    'slides-per-move' => 1 !== $this->slidesPerMove ? $this->slidesPerMove : null,
    'navigation' => $this->navigation,
    'pagination' => $this->pagination,
    'loop' => $this->loop,
    'mouse-dragging' => $this->mouseDragging,
    'autoplay' => $this->autoplay,
    'autoplay-interval' => 3000 !== $this->autoplayInterval ? $this->autoplayInterval : null,
])->toString() ?>>
    <?= Component::slot($this->previousIcon, 'previous-icon') ?>
    <?= Component::slot($this->nextIcon, 'next-icon') ?>
    <?php foreach ($this->items as $item): ?>
        <?= $item ?>
    <?php endforeach ?>
</wa-carousel>
