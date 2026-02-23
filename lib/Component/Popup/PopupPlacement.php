<?php

namespace Yakamara\Roadie\Component\Popup;

enum PopupPlacement: string
{
    case Top = 'top';
    case TopStart = 'top-start';
    case TopEnd = 'top-end';
    case Bottom = 'bottom';
    case BottomStart = 'bottom-start';
    case BottomEnd = 'bottom-end';
    case Right = 'right';
    case RightStart = 'right-start';
    case RightEnd = 'right-end';
    case Left = 'left';
    case LeftStart = 'left-start';
    case LeftEnd = 'left-end';
}
