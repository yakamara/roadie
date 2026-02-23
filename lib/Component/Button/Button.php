<?php

namespace Yakamara\Roadie\Component\Button;

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\HtmlAttributes;

/**
 * @see src/addons/roadie/lib/Component/Button/templates/Button.php
 */
/**
 * @summary Buttons represent actions that are available to the user.
 * @status experimental
 * @since 1.0
 *
 * @slot - The button's label.
 * @slot prefix - A presentational prefix icon or similar element.
 * @slot suffix - A presentational suffix icon or similar element.
 */
final class Button extends Component
{
    public function __construct(
        /**
         * The button's label.
         */
        public string|Component $label,

        /**
         * A presentational prefix icon or similar element.
         */
        public string|Component|null $start = null,

        /**
         * A presentational suffix icon or similar element.
         */
        public string|Component|null $end = null,

        /**
         * When set, the underlying button will be rendered
         * as an <a> with this href instead of a <button>.
         */
        public ?string $href = null,

        /**
         * Tells the browser where to open the link. Only
         * used when href is present.
         */
        public ?ButtonTarget $target = null,

        /**
         * When using `href`, this attribute will map to the underlying link's `rel` attribute. Unlike regular links, the
         * default is `noreferrer noopener` to prevent security exploits. However, if you're using `target` to point to a
         * specific tab/window, this will prevent that from working correctly. You can remove or change the default value by
         * setting the attribute to an empty string or a value of your choice, respectively.
         */
        public string $rel = 'noreferrer noopener',

        /**
         * The button's appearance.
         */
        public ButtonAppearance $appearance = ButtonAppearance::Accent,

        /**
         * The button's theme variant.
         */
        public ButtonVariant $variant = ButtonVariant::Default,

        /**
         * The button's size.
         */
        public ButtonSize $size = ButtonSize::Medium,

        /**
         * The type of button. Note that the default value
         * is button instead of submit, which is opposite
         * of how native <button> elements behave. When the
         * type is submit, the button will submit the
         * surrounding form.
         */
        public ButtonType $type = ButtonType::Button,

        /**
         * Disables the button.
         */
        public bool $disabled = false,

        /**
         * Draws a pill-style button with rounded edges.
         */
        public bool $pill = false,

        /**
         * Draws the button with a caret. Used to indicate
         * that the button triggers a dropdown menu or
         * similar behavior.
         */
        public bool $withCaret = false,

        /**
         * Draws the button in a loading state.
         */
        public bool $loading = false,

        /**
         * Tells the browser to download the linked file as this filename. Only used when href is present.
         */
        public ?string $download = null,

        /**
         * The URL to which to submit the form. Overrides the form's action. Only applies to type="submit".
         */
        public ?string $formAction = null,

        /**
         * The encoding type to use for form submission. Only applies to type="submit".
         */
        public ?ButtonFormEnctype $formEnctype = null,

        /**
         * The HTTP method to use for form submission. Only applies to type="submit".
         */
        public ?ButtonFormMethod $formMethod = null,

        /**
         * Prevents form validation on submission. Only applies to type="submit".
         */
        public bool $formNoValidate = false,

        /**
         * The target frame or window for the form submission. Only applies to type="submit".
         */
        public ?string $formTarget = null,

        /**
         * The name of the button, submitted as a
         * name/value pair with form data, but only when
         * this button is the submitter. This attribute is
         * ignored when href is present.
         */
        public ?string $name = null,

        /**
         * The value of the button, submitted as a pair with
         * the button's name as part of the form data, but
         * only when this button is the submitter. This
         * attribute is ignored when href is present.
         */
        public ?string $value = null,

        public HtmlAttributes $attributes = new HtmlAttributes(),
    ) {}

    protected function isButton(): bool
    {
        return !$this->href;
    }

    protected function isLink(): bool
    {
        return (bool) $this->href;
    }

    protected function getPath(): string
    {
        return 'Button.php';
    }
}
