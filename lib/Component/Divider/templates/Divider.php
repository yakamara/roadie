<?php

use Yakamara\Roadie\Component\Divider\Divider;
use Yakamara\Roadie\Component\Divider\DividerOrientation;

/** @var Divider $this */
?>

<wa-divider <?= $this->attributes->with([
    'orientation' => $this->orientation !== DividerOrientation::Horizontal ? $this->orientation : null,
])->toString() ?>></wa-divider>
