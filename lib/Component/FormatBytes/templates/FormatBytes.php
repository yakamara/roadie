<?php

use Yakamara\Roadie\Component\FormatBytes\FormatBytes;
use Yakamara\Roadie\Component\FormatBytes\FormatBytesDisplay;
use Yakamara\Roadie\Component\FormatBytes\FormatBytesUnit;

/** @var FormatBytes $this */
?>

<wa-format-bytes <?= $this->attributes->with([
    'value' => $this->value,
    'unit' => $this->unit !== FormatBytesUnit::Byte ? $this->unit : null,
    'display' => $this->display !== FormatBytesDisplay::Short ? $this->display : null,
    'lang' => $this->lang,
])->toString() ?>></wa-format-bytes>
