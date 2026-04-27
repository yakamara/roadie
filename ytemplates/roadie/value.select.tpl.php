<?php

use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Select\Option;
use Yakamara\Roadie\Component\Select\Select;

/**
 * @var rex_yform_value_abstract $this
 * @psalm-scope-this rex_yform_value_abstract
 */

$multiple ??= false;
$options ??= [];

$hasError = isset($this->params['warning_messages'][$this->getId()]);

$hintParts = [];
if ($notice = $this->getElement('notice')) {
    $hintParts[] = rex_i18n::translate($notice, false);
}
if ($hasError && !$this->params['hide_field_warning_messages']) {
    $hintParts[] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}
$hint = $hintParts ? implode(' ', $hintParts) : null;

$selectedValues = (array) $this->getValue();

$optionComponents = [];
foreach ($options as $key => $label) {
    $optionComponents[] = new Option(
        label: html_entity_decode($this->getLabelStyle($label), ENT_QUOTES | ENT_HTML5, 'UTF-8'),
        value: (string) $key,
        defaultSelected: in_array((string) $key, $selectedValues, true),
    );
}

$attrs = ['id' => $this->getHTMLId()];
if ($hasError) {
    $attrs['custom-error'] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}

echo (new Select(
    options: $optionComponents,
    label: $this->getLabel() ?: null,
    hint: $hint,
    name: $this->getFieldName(),
    value: $multiple ? implode(' ', array_filter($selectedValues)) : ($selectedValues[0] ?? null),
    multiple: $multiple,
    disabled: (bool) $this->getElement('disabled'),
    required: (bool) $this->getElement('required'),
    attributes: new HtmlAttributes($attrs),
))->render();
