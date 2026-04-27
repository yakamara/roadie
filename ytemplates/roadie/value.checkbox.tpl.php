<?php

use Yakamara\Roadie\Component\Checkbox\Checkbox;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @var rex_yform_value_checkbox $this
 * @psalm-scope-this rex_yform_value_checkbox
 */

$value ??= $this->getValue() ?? '';

$hasError = isset($this->params['warning_messages'][$this->getId()]);

$hintParts = [];
if ($notice = $this->getElement('notice')) {
    $hintParts[] = rex_i18n::translate($notice, false);
}
if ($hasError && !$this->params['hide_field_warning_messages']) {
    $hintParts[] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}

$attrs = ['id' => $this->getFieldId()];
if ($hasError) {
    $attrs['custom-error'] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}

echo (new Checkbox(
    label: $this->getLabel(),
    name: $this->getFieldName(),
    value: '1',
    checked: 1 == $value,
    disabled: (bool) $this->getElement('disabled'),
    required: (bool) $this->getElement('required'),
    hint: $hintParts ? implode(' ', $hintParts) : null,
    attributes: new HtmlAttributes($attrs),
))->render();
