<?php

namespace Yakamara\Roadie\Widget\LayoutPicker;

use function sprintf;

use const ENT_QUOTES;

/**
 * Generates SVG previews for the LayoutPicker based on a 12-column grid.
 *
 * The SVG is always 100 units wide; height is variable per picker.
 * Columns and blocks use `currentColor` so they inherit the CSS text color.
 * The vertical gap between rows equals the horizontal column gap.
 *
 * Usage:
 *   LayoutPickerSvg::build([
 *       new LayoutPickerSvgBlock(col: 1, span: 12),
 *   ]);
 *
 *   // Sidebar layout with header bar (2 rows)
 *   LayoutPickerSvg::build([
 *       new LayoutPickerSvgBlock(col: 1, span: 12, row: 1),
 *       new LayoutPickerSvgBlock(col: 1, span: 3,  row: 2),
 *       new LayoutPickerSvgBlock(col: 4, span: 9,  row: 2),
 *   ], rows: 2, height: 48);
 */
class LayoutPickerSvg
{
    private const int VIEW_WIDTH = 100;
    private const int COLS = 12;
    private const float PADDING_X = 2.0;
    private const float PADDING_Y = 3.0;
    private const float GAP = 2.0;
    private const float COL_WIDTH = (self::VIEW_WIDTH - 2 * self::PADDING_X - (self::COLS - 1) * self::GAP) / self::COLS;

    /**
     * @param list<LayoutPickerSvgBlock> $blocks
     */
    public static function build(array $blocks, int $height = 40, int $rows = 1): string
    {
        $availableHeight = $height - 2 * self::PADDING_Y;
        $rowHeight = ($availableHeight - ($rows - 1) * self::GAP) / $rows;
        $f = static fn (float $v, int $d = 4): string => number_format($v, $d, '.', '');

        $gridRects = '';
        for ($col = 1; $col <= self::COLS; ++$col) {
            $gridRects .= '<rect'
                . ' x="' . $f(self::colX($col)) . '"'
                . ' y="0"'
                . ' width="' . $f(self::COL_WIDTH) . '"'
                . ' height="' . $height . '"'
                . '/>';
        }

        $rects = '';
        $labels = '';
        foreach ($blocks as $block) {
            $blockX = self::colX($block->col);
            $blockY = self::PADDING_Y + ($block->row - 1) * ($rowHeight + self::GAP);
            $blockWidth = self::blockWidth($block->span);
            $blockHeight = $block->rowSpan * $rowHeight + ($block->rowSpan - 1) * self::GAP;
            $rects .= '<rect'
                . ' x="' . $f($blockX) . '"'
                . ' y="' . $f($blockY) . '"'
                . ' width="' . $f($blockWidth) . '"'
                . ' height="' . $f($blockHeight) . '"'
                . (null !== $block->fill ? ' fill="' . htmlspecialchars($block->fill, ENT_QUOTES) . '"' : '')
                . ' rx="1"/>';
            if (null !== $block->text) {
                $labels .= '<text'
                    . ' x="' . $f($blockX + $blockWidth / 2) . '"'
                    . ' y="' . $f($blockY + $blockHeight / 2) . '"'
                    . ' text-anchor="middle"'
                    . ' dominant-baseline="central">'
                    . htmlspecialchars($block->text, ENT_QUOTES)
                    . '</text>';
            }
        }

        return sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %1$d %2$d" width="%1$d" height="%2$d" aria-hidden="true">'
            . '<g fill="var(--roadie-layout-picker-layout, currentColor)">%3$s</g>'
            . '<g fill="var(--roadie-layout-picker-svg-block, currentColor)">%4$s</g>'
            . '<g fill="var(--roadie-layout-picker-svg-text, currentColor)" font-size="6" font-weight="bold">%5$s</g>'
            . '</svg>',
            self::VIEW_WIDTH,
            $height,
            $gridRects,
            $rects,
            $labels,
        );
    }

    private static function colX(int $col): float
    {
        return self::PADDING_X + ($col - 1) * (self::COL_WIDTH + self::GAP);
    }

    private static function blockWidth(int $span): float
    {
        return $span * self::COL_WIDTH + ($span - 1) * self::GAP;
    }
}
