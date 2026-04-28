<?php

use Yakamara\Roadie\Component\Checkbox\Checkbox;
use Yakamara\Roadie\Component\HtmlAttributes;
use Yakamara\Roadie\Component\Radio\Radio;
use Yakamara\Roadie\Component\RadioGroup\RadioGroup;

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
$fieldName = $this->getFieldName();
$fieldLabel = $this->getLabel() ?: null;
$allChoices = [...$choiceListView->getPreferredChoices(), ...$choiceListView->getChoices()];

// Component::slot() calls rex_escape() on strings, so pre-decode any existing HTML entities
$decode = static fn (string $s): string => html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');

if ($choiceList->isMultiple()) {
    $renderChoice = static function (rex_yform_choice_view $view) use ($selectedValues, $fieldName, $decode): string {
        return (new Checkbox(
            label: $decode($view->getLabel()),
            name: $fieldName,
            value: $view->getValue(),
            checked: in_array($view->getValue(), $selectedValues, true),
        ))->render();
    };
    ?>
    <fieldset id="<?= $this->getHTMLId() ?>">
        <?php if ($fieldLabel): ?>
            <legend><?= rex_escape($this->getLabelStyle($fieldLabel)) ?></legend>
        <?php endif ?>
        <?php foreach ($allChoices as $view): ?>
            <?php if ($view instanceof rex_yform_choice_group_view): ?>
                <fieldset>
                    <legend><?= rex_escape($view->getLabel()) ?></legend>
                    <?php foreach ($view->getChoices() as $choice): ?>
                        <?= $renderChoice($choice) ?>
                    <?php endforeach ?>
                </fieldset>
            <?php else: ?>
                <?= $renderChoice($view) ?>
            <?php endif ?>
        <?php endforeach ?>
        <?php if ($hint): ?>
            <p class="help-block small"><?= $hint ?></p>
        <?php endif ?>
    </fieldset>
    <?php
} else {
    $radios = [];
    foreach ($allChoices as $view) {
        if ($view instanceof rex_yform_choice_group_view) {
            foreach ($view->getChoices() as $choice) {
                $radios[] = new Radio(label: $decode($choice->getLabel()), value: $choice->getValue());
            }
        } else {
            $radios[] = new Radio(label: $decode($view->getLabel()), value: $view->getValue());
        }
    }

    echo (new RadioGroup(
        radios: $radios,
        label: $fieldLabel ? $decode($this->getLabelStyle($fieldLabel)) : null,
        hint: $hint,
        name: $fieldName,
        value: $selectedValues[0] ?? null,
        attributes: new HtmlAttributes(['id' => $this->getHTMLId()]),
    ))->render();
}
