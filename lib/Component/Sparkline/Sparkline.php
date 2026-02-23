<?php

namespace Yakamara\Roadie\Component\Sparkline;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Sparkline/templates/Sparkline.php
 */
/**
 * @summary Sparklines are small, inline charts for displaying data trends.
 * @status experimental
 * @since 1.0
 */
final class Sparkline extends Component
{
    public function __construct(
        /**
         * Space-separated numeric values (minimum two required).
         */
        public ?string $data = null,

        /**
         * Accessible screen reader description.
         */
        public ?string $label = null,

        /**
         * Visual fill style.
         */
        public SparklineAppearance $appearance = SparklineAppearance::Solid,

        /**
         * Line curve type.
         */
        public SparklineCurve $curve = SparklineCurve::Linear,

        /**
         * Visual trend indicator.
         */
        public ?SparklineTrend $trend = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'Sparkline.php';
    }
}
