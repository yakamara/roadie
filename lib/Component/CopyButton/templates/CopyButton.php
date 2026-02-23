<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\CopyButton\CopyButton;
use Yakamara\Roadie\Component\CopyButton\CopyButtonTooltipPlacement;

/** @var CopyButton $this */
?>

<wa-copy-button <?= $this->attributes->with([
    'value' => $this->value ?: null,
    'from' => $this->from ?: null,
    'disabled' => $this->disabled,
    'copy-label' => $this->copyLabel ?: null,
    'success-label' => $this->successLabel ?: null,
    'error-label' => $this->errorLabel ?: null,
    'feedback-duration' => $this->feedbackDuration !== 1000 ? $this->feedbackDuration : null,
    'tooltip-placement' => $this->tooltipPlacement !== CopyButtonTooltipPlacement::Top ? $this->tooltipPlacement : null,
])->toString() ?>>
    <?= Component::slot($this->copyIcon, 'copy-icon') ?>
    <?= Component::slot($this->successIcon, 'success-icon') ?>
    <?= Component::slot($this->errorIcon, 'error-icon') ?>
</wa-copy-button>
