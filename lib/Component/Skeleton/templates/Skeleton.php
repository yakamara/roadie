<?php

use Yakamara\Roadie\Component\Skeleton\Skeleton;
use Yakamara\Roadie\Component\Skeleton\SkeletonEffect;

/** @var Skeleton $this */
?>

<wa-skeleton <?= $this->attributes->with([
    'effect' => $this->effect !== SkeletonEffect::None ? $this->effect : null,
])->toString() ?>></wa-skeleton>
