<?php

/**
 * @var rex_yform $this
 * @psalm-scope-this rex_yform
 */

$hasAction = '' !== $this->objparams['form_action'];

if ($hasAction) {
    $actionUrl = $this->objparams['form_action'];
    $parts = explode('?', $actionUrl);

    $queryParams = [];
    if (2 === count($parts)) {
        parse_str(html_entity_decode($parts[1]), $queryParams);
    }
    if ([] !== $this->objparams['form_action_query_params']) {
        $queryParams += $this->objparams['form_action_query_params'];
        $actionUrl = $parts[0] . '?' . http_build_query($queryParams, '', '&amp;', PHP_QUERY_RFC3986);
    }

    $formClass = trim('wa-stack ' . $this->objparams['form_class']);
}

?>
<div id="<?= $this->objparams['form_wrap_id'] ?>" class="<?= $this->objparams['form_wrap_class'] ?>">

    <?php if ($hasAction): ?>
        <form action="<?= $actionUrl ?>" method="<?= $this->objparams['form_method'] ?>" id="<?= $this->objparams['form_name'] ?>" class="<?= $formClass ?>" enctype="multipart/form-data" novalidate>
    <?php endif ?>

        <?php if (!$this->objparams['hide_top_warning_messages'] && ($this->objparams['warning_messages'] || $this->objparams['unique_error'])): ?>
            <?= $this->parse('errors.tpl.php') ?>
        <?php endif ?>

        <?php foreach ($this->objparams['form_output'] as $field): ?>
            <?= $field ?>
        <?php endforeach ?>

        <?php for ($i = 0; $i < $this->objparams['fieldsets_opened']; ++$i): ?>
            <?= $this->parse('value.fieldset.tpl.php', ['option' => 'close']) ?>
        <?php endfor ?>

        <?php
        $renderHidden = static function (string $key, mixed $value) use (&$renderHidden): void {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $renderHidden($key . '[' . $k . ']', $v);
                }
            } else {
                echo '<input type="hidden" name="' . $key . '" value="' . rex_escape($value) . '">' . "\n";
            }
        };

        foreach ($this->objparams['form_hiddenfields'] as $k => $v) {
            $renderHidden((string) $k, $v);
        }
        ?>

    <?php if ($hasAction): ?>
        </form>
    <?php endif ?>

</div>
