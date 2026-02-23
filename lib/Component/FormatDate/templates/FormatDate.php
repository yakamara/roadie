<?php

use Yakamara\Roadie\Component\FormatDate\FormatDate;
use Yakamara\Roadie\Component\FormatDate\FormatDateHourFormat;

/** @var FormatDate $this */
?>

<wa-format-date <?= $this->attributes->with([
    'date' => $this->date,
    'weekday' => $this->weekday,
    'era' => $this->era,
    'year' => $this->year,
    'month' => $this->month,
    'day' => $this->day,
    'hour' => $this->hour,
    'minute' => $this->minute,
    'second' => $this->second,
    'hour-format' => $this->hourFormat !== FormatDateHourFormat::Auto ? $this->hourFormat : null,
    'time-zone' => $this->timeZone,
    'time-zone-name' => $this->timeZoneName,
    'lang' => $this->lang,
])->toString() ?>></wa-format-date>
