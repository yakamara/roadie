<?php

use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Textarea\Textarea;

/**
 * @var rex_yform_value_textarea $this
 * @psalm-scope-this rex_yform_value_textarea
 */

$hasError = isset($this->params['warning_messages'][$this->getId()]);

$hintParts = [];
if ($notice = $this->getElement('notice')) {
    $hintParts[] = rex_i18n::translate($notice, false);
}
if ($hasError && !$this->params['hide_field_warning_messages']) {
    $hintParts[] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}

$rows = (int) ($this->getElement('rows') ?: 4);

$attrs = ['id' => $this->getFieldId()];
if ($hasError) {
    $attrs['custom-error'] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}

echo (new Textarea(
    label: $this->getLabel(),
    hint: $hintParts ? implode(' ', $hintParts) : null,
    value: '' !== $this->getValue() ? $this->getValue() : null,
    placeholder: $this->getElement('placeholder') ?: null,
    name: $this->getFieldName(),
    disabled: (bool) $this->getElement('disabled'),
    readonly: (bool) $this->getElement('readonly'),
    required: (bool) $this->getElement('required'),
    rows: $rows,
    attributes: new HtmlAttributes($attrs),
))->render();
