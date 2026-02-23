<?php

namespace Yakamara\Roadie\Component;

use Closure;
use rex_type;

use function is_string;

final class Html extends Component
{
    public function __construct(
        /** @var string|Component|Closure */
        public string|array|Closure $value,
    ) {}

    public function render(): string
    {
        if (is_string($this->value)) {
            return $this->value;
        }

        if ($this->value instanceof Closure) {
            ob_start();
            ($this->value)();

            return rex_type::string(ob_get_clean());
        }

        return implode('', array_map(static function (string|Component|null $value): string {
            if ($value instanceof Component) {
                return $value->render();
            }

            return $value ?? '';
        }, $this->value));
    }
}
