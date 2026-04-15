<?php

use Yakamara\Roadie\Component\Button\Button;
use Yakamara\Roadie\Component\Button\ButtonType;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @var rex_yform_value_submit $this
 * @psalm-scope-this rex_yform_value_submit
 */

$labels ??= [];

if (count($labels) > 1) {
    echo '<div class="wa-cluster">';
}

foreach ($labels as $index => $label) {
    $id = $this->getFieldId() . '-' . rex_string::normalize($label);

    echo (new Button(
        label: rex_i18n::translate($label, true),
        type: ButtonType::Submit,
        name: $this->getFieldName(),
        value: '1',
        attributes: new HtmlAttributes([
            'id' => $id,
        ]),
    ))->render();
}

if (count($labels) > 1) {
    echo '</div>';
}
