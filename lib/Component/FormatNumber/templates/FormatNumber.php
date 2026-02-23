<?php

use Yakamara\Roadie\Component\FormatNumber\FormatNumber;
use Yakamara\Roadie\Component\FormatNumber\FormatNumberCurrencyDisplay;
use Yakamara\Roadie\Component\FormatNumber\FormatNumberType;

/** @var FormatNumber $this */
?>

<wa-format-number <?= $this->attributes->with([
    'value' => $this->value,
    'type' => $this->type !== FormatNumberType::Decimal ? $this->type : null,
    'currency' => $this->type === FormatNumberType::Currency ? $this->currency : null,
    'currency-display' => $this->type === FormatNumberType::Currency && $this->currencyDisplay !== FormatNumberCurrencyDisplay::Symbol ? $this->currencyDisplay : null,
    'minimum-fraction-digits' => $this->minimumFractionDigits,
    'maximum-fraction-digits' => $this->maximumFractionDigits,
    'minimum-integer-digits' => $this->minimumIntegerDigits,
    'minimum-significant-digits' => $this->minimumSignificantDigits,
    'maximum-significant-digits' => $this->maximumSignificantDigits,
    'without-grouping' => $this->withoutGrouping,
])->toString() ?>></wa-format-number>
