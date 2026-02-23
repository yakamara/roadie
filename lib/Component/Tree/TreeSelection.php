<?php

namespace Yakamara\Roadie\Component\Tree;

enum TreeSelection: string
{
    case Single = 'single';
    case Multiple = 'multiple';
    case Leaf = 'leaf';
}
