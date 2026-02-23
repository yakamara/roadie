<?php

use Yakamara\Roadie\Component\QrCode\QrCode;
use Yakamara\Roadie\Component\QrCode\QrCodeErrorCorrection;

/** @var QrCode $this */
?>

<wa-qr-code <?= $this->attributes->with([
    'value' => $this->value,
    'label' => $this->label,
    'size' => $this->size !== 128 ? $this->size : null,
    'error-correction' => $this->errorCorrection !== QrCodeErrorCorrection::High ? $this->errorCorrection : null,
    'radius' => $this->radius !== 0.0 ? $this->radius : null,
    'fill' => $this->fill,
    'background' => $this->background,
])->toString() ?>></wa-qr-code>
