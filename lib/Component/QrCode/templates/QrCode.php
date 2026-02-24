<?php

use Yakamara\Roadie\Component\QrCode\QrCode;
use Yakamara\Roadie\Component\QrCode\QrCodeErrorCorrection;

/** @var QrCode $this */
?>

<wa-qr-code <?= $this->attributes->with([
    'value' => $this->value,
    'label' => $this->label,
    'size' => 128 !== $this->size ? $this->size : null,
    'error-correction' => QrCodeErrorCorrection::High !== $this->errorCorrection ? $this->errorCorrection : null,
    'radius' => 0.0 !== $this->radius ? $this->radius : null,
    'fill' => $this->fill,
    'background' => $this->background,
])->toString() ?>></wa-qr-code>
