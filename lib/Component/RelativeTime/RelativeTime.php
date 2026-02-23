<?php

namespace Yakamara\Roadie\Component\RelativeTime;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttribute\Lang;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/RelativeTime/templates/RelativeTime.php
 */
/**
 * @summary Outputs a localized time phrase relative to the current date and time.
 * @status stable
 * @since 1.0
 */
final class RelativeTime extends Component
{
    public function __construct(
        /**
         * The date from which to calculate time from. Accepts ISO 8601 strings.
         * If not set, the current date and time will be used.
         */
        public ?string $date = null,

        /**
         * The styling to use for the relative time.
         */
        public RelativeTimeFormat $format = RelativeTimeFormat::Long,

        /**
         * Controls whether to always use numeric values ("3 days ago") or
         * natural language ("yesterday") when possible.
         */
        public RelativeTimeNumeric $numeric = RelativeTimeNumeric::Auto,

        /**
         * Keep the displayed value up to date as time passes.
         */
        public bool $sync = false,

        /**
         * The locale to use for formatting. Defaults to the browser's locale.
         */
        public ?Lang $lang = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'RelativeTime.php';
    }
}
