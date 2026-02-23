<?php

namespace Yakamara\Roadie\Component\QrCode;

enum QrCodeErrorCorrection: string
{
    case Low = 'L';
    case Medium = 'M';
    case Quartile = 'Q';
    case High = 'H';
}
