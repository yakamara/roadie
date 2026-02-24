<?php

use Yakamara\Roadie\Component\ButtonGroup\ButtonGroup;
use Yakamara\Roadie\Component\ButtonGroup\ButtonGroupOrientation;

/** @var ButtonGroup $this */
?>

<wa-button-group <?= $this->attributes->with([
    'label' => $this->label ?: null,
    'orientation' => ButtonGroupOrientation::Horizontal !== $this->orientation ? $this->orientation : null,
])->toString() ?>>
    <?php foreach ($this->buttons as $button): ?>
        <?= $button ?>
    <?php endforeach ?>
</wa-button-group>
