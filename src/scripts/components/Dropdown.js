import Component from '../core/Component.js';

/**
 * Generic Dropdown component.
 *
 * HTML:
 *   <div data-component="dropdown" data-dropdown-close-on-select="true">
 *     <button data-target="dropdown.trigger"
 *             data-action="click:toggle keydown:onTriggerKey"
 *             aria-haspopup="listbox" aria-expanded="false">
 *       Label
 *     </button>
 *     <ul data-target="dropdown.menu" role="listbox">
 *       <li role="option" data-value="A" data-action="click:select" tabindex="-1">A</li>
 *       <li role="option" data-value="B" data-action="click:select" tabindex="-1">B</li>
 *     </ul>
 *   </div>
 *
 * Optional: data-target="dropdown.display" — element whose textContent updates on select.
 */
export default class Dropdown extends Component {
  static componentName = 'dropdown';
  static defaults = {
    closeOnSelect: 'true',
  };

  init() {
    this.trigger = this.target('trigger');
    this.menu = this.target('menu');
    this.display = this.target('display');

    if (!this.trigger || !this.menu) {
      console.warn('[Dropdown] Missing trigger or menu target', this.el);
      return;
    }

    this.isOpen = false;

    // Keyboard navigation inside menu
    this.on(this.menu, 'keydown', this._onMenuKeydown.bind(this));

    // Close on outside click
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
    requestAnimationFrame(() => {
      const focused =
        this.menu.querySelector('[role="option"][aria-selected="true"]') ||
        this.menu.querySelector('[role="option"]');
      focused?.focus();
    });
  }

  open() {
    this.emit('dropdown:beforeopen');
    this.el.classList.remove('closing');
    this.el.classList.add('open');
    this.trigger.setAttribute('aria-expanded', 'true');
    this.isOpen = true;
  }

  close() {
    if (!this.isOpen) return;
    this.trigger.setAttribute('aria-expanded', 'false');
    this.el.classList.remove('open');
    this.el.classList.add('closing');
    this.menu.addEventListener(
      'animationend',
      () => this.el.classList.remove('closing'),
      { once: true }
    );
    this.isOpen = false;
  }

  select(e, actionEl) {
    const option = actionEl.closest('[role="option"]');
    if (!option) return;

    // Update aria-selected
    this.menu
      .querySelectorAll('[role="option"]')
      .forEach((o) => o.setAttribute('aria-selected', 'false'));
    option.setAttribute('aria-selected', 'true');

    // Update display element
    if (this.display) {
      this.display.textContent = option.dataset.value ?? '';
    }

    this.emit('dropdown:select', { value: option.dataset.value });

    if (this.opts.closeOnSelect === 'true') {
      this.close();
    }
  }

  // ---------------------------------------------------------------------------
  // Private
  // ---------------------------------------------------------------------------

  _onMenuKeydown(e) {
    const options = [...this.menu.querySelectorAll('[role="option"]')];
    const idx = options.indexOf(document.activeElement);

    switch (e.key) {
      case 'ArrowDown':
        e.preventDefault();
        options[(idx + 1) % options.length]?.focus();
        break;
      case 'ArrowUp':
        e.preventDefault();
        options[(idx - 1 + options.length) % options.length]?.focus();
        break;
      case 'Home':
        e.preventDefault();
        options[0]?.focus();
        break;
      case 'End':
        e.preventDefault();
        options[options.length - 1]?.focus();
        break;
      case 'Escape':
        this.close();
        this.trigger.focus();
        break;
      case 'Enter':
      case ' ':
        e.preventDefault();
        document.activeElement?.click();
        break;
    }
  }
}
