<?php

namespace Yakamara\Roadie\Component\FormatNumber;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/FormatNumber/templates/FormatNumber.php
 */
/**
 * @summary Formats a number using the specified locale and options.
 * @status stable
 * @since 1.0
 */
final class FormatNumber extends Component
{
    public function __construct(
        /**
         * The number to format.
         */
        public float $value = 0,

        /**
         * The formatting style to use.
         */
        public FormatNumberType $type = FormatNumberType::Decimal,

        /**
         * The ISO 4217 currency code to use when formatting currency.
         */
        public string $currency = 'USD',

        /**
         * How to display the currency.
         */
        public FormatNumberCurrencyDisplay $currencyDisplay = FormatNumberCurrencyDisplay::Symbol,

        /**
         * The minimum number of fraction digits to use (0–100).
         */
        public ?int $minimumFractionDigits = null,

        /**
         * The maximum number of fraction digits to use (0–100).
         */
        public ?int $maximumFractionDigits = null,

        /**
         * The minimum number of integer digits to use (1–21).
         */
        public ?int $minimumIntegerDigits = null,

        /**
         * The minimum number of significant digits to use (1–21).
         */
        public ?int $minimumSignificantDigits = null,

        /**
         * The maximum number of significant digits to use (1–21).
         */
        public ?int $maximumSignificantDigits = null,

        /**
         * Turns off grouping separators (e.g. thousands separator).
         */
        public bool $withoutGrouping = false,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'FormatNumber.php';
    }
}
