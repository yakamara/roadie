<?php

namespace Yakamara\Roadie\Util;

use Symfony\Component\Uid\Uuid;

use function chr;
use function ord;

final class Aria
{
    private static string $lastId = '';

    /**
     * Generiert eine eindeutige ID für aria-Attribute und speichert sie für lastId().
     * Die ID beginnt garantiert mit einem Buchstaben (a–p) und ist gültiges HTML.
     */
    public static function id(): string
    {
        $hex = str_replace('-', '', Uuid::v4()->toRfc4122());
        return self::$lastId = chr(ord('a') + hexdec($hex[0])) . substr($hex, 1, 7);
    }

    /**
     * Gibt die zuletzt generierte ID zurück, ohne eine neue zu erzeugen.
     */
    public static function lastId(): string
    {
        return self::$lastId;
    }
}
