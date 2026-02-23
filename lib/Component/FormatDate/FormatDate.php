<?php

namespace Yakamara\Roadie\Component\FormatDate;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/FormatDate/templates/FormatDate.php
 */
/**
 * @summary Formats a date/time using the specified locale and options.
 * @status stable
 * @since 1.0
 */
final class FormatDate extends Component
{
    public function __construct(
        /**
         * The date/time to format. Accepts a Date object or ISO 8601 string.
         */
        public ?string $date = null,

        /**
         * The format for displaying the weekday.
         */
        public ?FormatDateWeekday $weekday = null,

        /**
         * The format for displaying the era.
         */
        public ?FormatDateEra $era = null,

        /**
         * The format for displaying the year.
         */
        public ?FormatDateYear $year = null,

        /**
         * The format for displaying the month.
         */
        public ?FormatDateMonth $month = null,

        /**
         * The format for displaying the day.
         */
        public ?FormatDateDay $day = null,

        /**
         * The format for displaying the hour.
         */
        public ?FormatDateHour $hour = null,

        /**
         * The format for displaying the minute.
         */
        public ?FormatDateMinute $minute = null,

        /**
         * The format for displaying the second.
         */
        public ?FormatDateSecond $second = null,

        /**
         * The format for the hour (12h or 24h).
         */
        public FormatDateHourFormat $hourFormat = FormatDateHourFormat::Auto,

        /**
         * The time zone to express the time in.
         */
        public ?string $timeZone = null,

        /**
         * The format for displaying the time zone name.
         */
        public ?FormatDateTimeZoneName $timeZoneName = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'FormatDate.php';
    }
}
