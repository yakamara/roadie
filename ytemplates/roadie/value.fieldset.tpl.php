<?php

/**
 * @var rex_yform_value_abstract|rex_yform $this
 * @psalm-scope-this rex_yform_value_abstract
 */

$option ??= '';

if ('open' === $option) {
    echo '<fieldset class="' . $this->getHTMLClass() . '" id="' . $this->getHTMLId() . '">';
    if ($this->getLabel()) {
        echo '<legend id="' . $this->getFieldId() . '">' . $this->getLabel() . '</legend>';
    }
} elseif ('close' === $option) {
    echo '</fieldset>';
}
