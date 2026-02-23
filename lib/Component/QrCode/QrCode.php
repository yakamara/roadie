<?php

namespace Yakamara\Roadie\Component\QrCode;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/QrCode/templates/QrCode.php
 */
/**
 * @summary Generates a QR code and renders it using the Canvas API.
 * @status stable
 * @since 1.0
 */
final class QrCode extends Component
{
    public function __construct(
        /**
         * The data to encode in the QR code.
         */
        public ?string $value = null,

        /**
         * Accessible label for assistive devices. Defaults to the value if omitted.
         */
        public ?string $label = null,

        /**
         * QR code dimensions in pixels.
         */
        public int $size = 128,

        /**
         * Error correction level.
         */
        public QrCodeErrorCorrection $errorCorrection = QrCodeErrorCorrection::High,

        /**
         * Edge radius per module (0–0.5).
         */
        public float $radius = 0,

        /**
         * Fill color (any valid CSS color; no custom properties).
         */
        public ?string $fill = null,

        /**
         * Background color (any valid CSS color or "transparent").
         */
        public ?string $background = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'QrCode.php';
    }
}
