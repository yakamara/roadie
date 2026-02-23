<?php

namespace Yakamara\Roadie\Component\Button;

enum ButtonFormEnctype: string
{
    case UrlEncoded = 'application/x-www-form-urlencoded';
    case Multipart = 'multipart/form-data';
    case Plain = 'text/plain';
}
