<?php

namespace Yakamara\Roadie\Widget\LayoutPicker;

readonly class LayoutPickerSvgBlock
{
    public function __construct(
        /**
         * 1-based start column (1–12).
         */
        public int $col,

        /**
         * Number of columns to span (1–12).
         */
        public int $span,

        /**
         * 1-based row index.
         */
        public int $row = 1,

        /**
         * Number of rows to span.
         */
        public int $rowSpan = 1,

        /**
         * Optional fill color for this block (e.g. "#e63946" or "var(--color-primary)").
         * Overrides the group's --roadie-layout-picker-svg-block variable.
         */
        public ?string $fill = null,

        /**
         * Optional label rendered centered on the block.
         */
        public ?string $text = null,
    ) {}
}
