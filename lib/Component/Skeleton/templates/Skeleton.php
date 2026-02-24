<?php

use Yakamara\Roadie\Component\Skeleton\Skeleton;
use Yakamara\Roadie\Component\Skeleton\SkeletonEffect;

/** @var Skeleton $this */
?>

<wa-skeleton <?= $this->attributes->with([
    'effect' => SkeletonEffect::None !== $this->effect ? $this->effect : null,
])->toString() ?>></wa-skeleton>
