<?php

use Yakamara\Roadie\Component\Html;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Input\Input;
use Yakamara\Roadie\Component\Input\InputType;

/**
 * @var rex_yform_value_text $this
 * @psalm-scope-this rex_yform_value_text
 */

$type ??= 'text';
$value ??= $this->getValue();

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

echo (new Input(
    type: InputType::tryFrom($type) ?? InputType::Text,
    label: $this->getLabel(),
    hint: $hintParts ? implode(' ', $hintParts) : null,
    name: $this->getFieldName(),
    value: '' !== $value ? $value : null,
    placeholder: $this->getElement('placeholder') ?: null,
    disabled: (bool) $this->getElement('disabled'),
    readonly: (bool) $this->getElement('readonly'),
    required: (bool) $this->getElement('required'),
    pattern: $this->getElement('pattern') ?: null,
    autocomplete: $this->getElement('autocomplete') ?: null,
    start: !empty($prepend) ? new Html($prepend) : null,
    end: !empty($append) ? new Html($append) : null,
    attributes: new HtmlAttributes($attrs),
))->render();
