<?php

use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Select\Option;
use Yakamara\Roadie\Component\Select\Select;

/**
 * @var rex_yform_value_abstract $this
 * @psalm-scope-this rex_yform_value_abstract
 * @var rex_yform_choice_list $choiceList
 * @var rex_yform_choice_list_view $choiceListView
 */

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
$isMultiple = $choiceList->isMultiple();

// Component::slot() calls rex_escape() on strings, so pre-decode any existing HTML entities
$decode = static fn(string $s): string => html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

$buildOptions = static function (array $choices) use ($selectedValues, $decode): array {
    $options = [];
    foreach ($choices as $view) {
        if ($view instanceof rex_yform_choice_group_view) {
            $options[] = new Option(label: $decode($view->getLabel()), disabled: true);
            foreach ($view->getChoices() as $choice) {
                $options[] = new Option(
                    label: $decode($choice->getLabel()),
                    value: $choice->getValue(),
                    defaultSelected: in_array($choice->getValue(), $selectedValues, true),
                );
            }
        } else {
            $options[] = new Option(
                label: $decode($view->getLabel()),
                value: $view->getValue(),
                defaultSelected: in_array($view->getValue(), $selectedValues, true),
            );
        }
    }
    return $options;
};

$options = [];
$preferredChoices = $choiceListView->getPreferredChoices();
if ($preferredChoices) {
    $options = [...$buildOptions($preferredChoices), new Option(label: '-------------------', disabled: true)];
}
$options = [...$options, ...$buildOptions($choiceListView->getChoices())];

$attrs = ['id' => $this->getHTMLId()];
if ($hasError) {
    $attrs['custom-error'] = rex_i18n::translate($this->params['warning_messages'][$this->getId()]);
}

echo (new Select(
    options: $options,
    label: $decode($this->getLabel()),
    hint: $hint,
    name: $this->getFieldName(),
    value: $isMultiple ? implode(' ', array_filter($selectedValues)) : ($selectedValues[0] ?? null),
    placeholder: $choiceList->getPlaceholder() ?: null,
    multiple: $isMultiple,
    disabled: isset($this->params['fixdata'][$this->getName()]),
    attributes: new HtmlAttributes($attrs),
))->render();
