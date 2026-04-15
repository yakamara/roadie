<?php

use Yakamara\Roadie\Component\Callout\Callout;
use Yakamara\Roadie\Component\Callout\CalloutAppearance;
use Yakamara\Roadie\Component\Callout\CalloutVariant;
use Yakamara\Roadie\Component\Html;

/**
 * @var rex_yform $this
 * @psalm-scope-this rex_yform
 */

if (!$this->objparams['warning_messages'] && !$this->objparams['unique_error']) {
    return;
}

$content = '';

if ($this->objparams['Error-occured']) {
    $content .= '<strong>' . rex_escape($this->objparams['Error-occured']) . '</strong>';
}

if ($this->objparams['hide_field_warning_messages']) {
    $items = [];

    foreach ($this->objparams['warning_messages'] as $k => $v) {
        $message = rex_i18n::translate($v, false);
        if ('' === $message && isset($this->objparams['values'][$k])) {
            $message = rex_addon::get('yform')->i18n('yform_values_message_is_missing', $this->objparams['values'][$k]->getLabel(), $this->objparams['values'][$k]->getName());
        }
        $items[$message] = '<li>' . rex_escape($message) . '</li>';
    }

    if ('' !== $this->objparams['unique_error']) {
        $message = rex_i18n::translate(preg_replace('~\*|:|\(.*\)~Usim', '', $this->objparams['unique_error']));
        $items[$message] = '<li>' . rex_escape($message) . '</li>';
    }

    if ($items) {
        $content .= '<ul>' . implode('', $items) . '</ul>';
    }
}

echo (new Callout(
    content: new Html($content),
    appearance: CalloutAppearance::Accent,
    variant: CalloutVariant::Danger,
))->render();
