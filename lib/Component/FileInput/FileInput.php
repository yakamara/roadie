<?php

namespace Yakamara\Roadie\Component\FileInput;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/FileInput/templates/FileInput.php
 */
/**
 * @summary File inputs allow the user to select one or more files.
 * @status stable
 * @since 1.0
 *
 * @slot label     - The file input's label. Overrides the label attribute.
 * @slot hint      - The file input's hint text. Overrides the hint attribute.
 * @slot dropzone  - Custom content shown in the dropzone area.
 * @slot file-icon - Custom icon for non-image files.
 */
final class FileInput extends Component
{
    public function __construct(
        /**
         * The file input's label.
         */
        public string|Component|null $label = null,

        /**
         * Descriptive hint text shown below the file input.
         */
        public string|Component|null $hint = null,

        /**
         * Comma-separated list of acceptable file type specifiers.
         */
        public ?string $accept = null,

        /**
         * Allows selecting more than one file.
         */
        public bool $multiple = false,

        /**
         * Makes the file input required.
         */
        public bool $required = false,

        /**
         * The file input's size.
         */
        public FileInputSize $size = FileInputSize::Medium,

        /**
         * Custom content shown in the dropzone area.
         */
        public string|Component|null $dropzone = null,

        /**
         * Custom icon for non-image files.
         */
        public string|Component|null $fileIcon = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function getPath(): string
    {
        return 'FileInput.php';
    }
}
