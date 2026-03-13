import Component from '../../../../src/scripts/core/Component.js';

/**
 * Listbox component.
 *
 * HTML:
 *   <div data-component="listbox" class="roadie-listbox">
 *     <button data-target="listbox.trigger"
 *             data-action="click:toggle keydown:onTriggerKey"
 *             aria-haspopup="listbox" aria-expanded="false" aria-controls="...">
 *       <span data-target="listbox.display">Label</span>
 *     </button>
 *     <ul data-target="listbox.menu" role="listbox" aria-label="...">
 *       <li role="option" aria-selected="false" data-value="A">
 *         <a href="...">A</a>
 *       </li>
 *     </ul>
 *   </div>
 */
export default class Listbox extends Component {
    static componentName = 'listbox';
    static defaults = {};

    init() {
        this.trigger = this.target('trigger');
        this.menu    = this.target('menu');
        this.display = this.target('display');

        if (!this.trigger || !this.menu) {
            console.warn('[Listbox] Missing trigger or menu target', this.el);
            return;
        }

        this.isOpen = false;

        this.on(this.menu, 'keydown', this._onMenuKeydown.bind(this));

        this._onDocClick = (e) => {
            if (!this.el.contains(e.target)) this.close();
        };
        document.addEventListener('click', this._onDocClick);
    }

    destroy() {
        document.removeEventListener('click', this._onDocClick);
        super.destroy();
    }

    // ---------------------------------------------------------------------------
    // Actions (called via data-action)
    // ---------------------------------------------------------------------------

    toggle(e) {
        e.stopPropagation();
        this.isOpen ? this.close() : this.open();
    }

    onTriggerKey(e) {
        if (e.key !== 'Enter' && e.key !== ' ' && e.key !== 'ArrowDown') return;
        e.preventDefault();
        if (!this.isOpen) this.open();
    }

    select(e, actionEl) {
        const option = actionEl.closest('[role="option"]');
        if (!option) return;

        this.menu
            .querySelectorAll('[role="option"]')
            .forEach((o) => o.setAttribute('aria-selected', 'false'));
        option.setAttribute('aria-selected', 'true');

        if (this.display) {
            this.display.textContent = option.dataset.value ?? '';
        }

        this.emit('listbox:select', { value: option.dataset.value });
        this.close();
    }

    // ---------------------------------------------------------------------------
    // Open / Close
    // ---------------------------------------------------------------------------

    open() {
        this.el.classList.add('open');
        this.trigger.setAttribute('aria-expanded', 'true');
        this.isOpen = true;
        requestAnimationFrame(() => this._focusables()[0]?.focus());
    }

    close() {
        if (!this.isOpen) return;
        this.trigger.setAttribute('aria-expanded', 'false');
        this.el.classList.remove('open');
        this.el.classList.add('closing');
        this.isOpen = false;

        const cleanup = () => this.el.classList.remove('closing');
        this.menu.addEventListener('animationend', cleanup, { once: true });
        setTimeout(cleanup, 100);
    }

    // ---------------------------------------------------------------------------
    // Private
    // ---------------------------------------------------------------------------

    _focusables() {
        return [...this.menu.querySelectorAll('a[href], button:not([disabled])')];
    }

    _onMenuKeydown(e) {
        const focusables = this._focusables();
        const first = focusables[0];
        const last  = focusables[focusables.length - 1];

        switch (e.key) {
            case 'Tab':
                if (e.shiftKey && document.activeElement === first) {
                    e.preventDefault();
                    this.close();
                    this.trigger.focus();
                }
                if (!e.shiftKey && document.activeElement === last) {
                    this.close();
                }
                break;
            case 'Escape':
                this.close();
                this.trigger.focus();
                break;
        }
    }
}
