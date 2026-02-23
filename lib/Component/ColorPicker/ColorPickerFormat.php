<?php

namespace Yakamara\Roadie\Component\ColorPicker;

enum ColorPickerFormat: string
{
    case Hex = 'hex';
    case Rgb = 'rgb';
    case Hsl = 'hsl';
    case Hsv = 'hsv';
}
