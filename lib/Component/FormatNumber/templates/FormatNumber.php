<?php

use Yakamara\Roadie\Component\FormatNumber\FormatNumber;
use Yakamara\Roadie\Component\FormatNumber\FormatNumberCurrencyDisplay;
use Yakamara\Roadie\Component\FormatNumber\FormatNumberType;

/** @var FormatNumber $this */
?>

<wa-format-number <?= $this->attributes->with([
    'value' => $this->value,
    'type' => FormatNumberType::Decimal !== $this->type ? $this->type : null,
    'currency' => FormatNumberType::Currency === $this->type ? $this->currency : null,
    'currency-display' => FormatNumberType::Currency === $this->type && FormatNumberCurrencyDisplay::Symbol !== $this->currencyDisplay ? $this->currencyDisplay : null,
    'minimum-fraction-digits' => $this->minimumFractionDigits,
    'maximum-fraction-digits' => $this->maximumFractionDigits,
    'minimum-integer-digits' => $this->minimumIntegerDigits,
    'minimum-significant-digits' => $this->minimumSignificantDigits,
    'maximum-significant-digits' => $this->maximumSignificantDigits,
    'without-grouping' => $this->withoutGrouping,
    'lang' => $this->lang,
])->toString() ?>></wa-format-number>
