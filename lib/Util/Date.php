<?php

namespace Yakamara\Roadie\Util;

use HillValley\Fluxcap\Date as FluxDate;

final class Date
{
    public static function between(string $date, string $start, string $end): bool
    {
        $date = FluxDate::fromString($date);
        $start = FluxDate::fromString($start);
        $end = FluxDate::fromString($end);

        return (int) $date->format('Ymd') > (int) $start->format('Ymd') && (int) $date->format('Ymd') < (int) $end->format('Ymd');
    }

    public static function betweenOrSame(string $date, string $start, string $end): bool
    {
        $date = FluxDate::fromString($date);
        $start = FluxDate::fromString($start);
        $end = FluxDate::fromString($end);

        return (int) $date->format('Ymd') >= (int) $start->format('Ymd') && (int) $date->format('Ymd') <= (int) $end->format('Ymd');
    }

    public static function before(string $date, string $comparisonDate): bool
    {
        $date = FluxDate::fromString($date);
        $comparisonDate = FluxDate::fromString($comparisonDate);

        return (int) $date->format('Ymd') < (int) $comparisonDate->format('Ymd');
    }

    public static function after(string $date, string $comparisonDate): bool
    {
        $date = FluxDate::fromString($date);
        $comparisonDate = FluxDate::fromString($comparisonDate);

        return (int) $date->format('Ymd') > (int) $comparisonDate->format('Ymd');
    }
}
