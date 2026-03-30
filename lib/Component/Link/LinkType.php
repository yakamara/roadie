<?php

namespace Yakamara\Roadie\Component\Link;

use rex_string;

enum LinkType
{
    case Anker;
    case External;
    case Download;
    case Email;
    case File;
    case Internal;
    case Phone;
    case Sms;

    public function getProtocol(): string
    {
        return match ($this) {
            self::Anker => '#',
            self::External => 'https://',
            self::Email => 'mailto:',
            self::Phone => 'tel:',
            self::Sms => 'sms:',
            default => '',
        };
    }

    public function getHref(string $href): string
    {
        $href = match ($this) {
            self::Anker => rex_string::normalize($href, '-'),
            self::Phone,
            self::Sms => preg_replace('/[^0-9]+/', '', $href),
            default => $href,
        };
        return $this->getProtocol().$href;
    }

    public function getAttributes(): array
    {
        return match ($this) {
            self::Download => ['itemprop' => 'downloadUrl', 'download' => true],
            self::Email => ['itemprop' => 'email'],
            self::Phone => ['itemprop' => 'telephone'],
            default => [],
        };
    }
}
