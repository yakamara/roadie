<?php

use Yakamara\Roadie\Component\RelativeTime\RelativeTime;
use Yakamara\Roadie\Component\RelativeTime\RelativeTimeFormat;
use Yakamara\Roadie\Component\RelativeTime\RelativeTimeNumeric;

/** @var RelativeTime $this */
?>

<wa-relative-time <?= $this->attributes->with([
    'date' => $this->date,
    'format' => $this->format !== RelativeTimeFormat::Long ? $this->format : null,
    'numeric' => $this->numeric !== RelativeTimeNumeric::Auto ? $this->numeric : null,
    'sync' => $this->sync,
    'lang' => $this->lang,
])->toString() ?>></wa-relative-time>
