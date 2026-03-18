/**
 * Base Component class.
 *
 * Every component extends this class and sets:
 *   static componentName = 'my-component';   // kebab-case, matches data-component="my-component"
 *   static defaults = { ... };               // merged with data-attribute config
 *
 * HTML contract:
 *   data-component="my-component"            — root element
 *   data-target="my-component.trigger"       — child elements the component needs
 *   data-action="click:toggle"               — delegated event → method call
 *   data-my-component-option="value"         — component-specific configuration
 *
 * data-target supports space-separated values so an element can serve multiple roles:
 *   data-target="my-component.input my-component.label"
 *
 * Target naming convention:
 *   Short generic names (e.g. "field", "panel", "label") act as role markers — use
 *   targets() / closestTarget() / targetIn() / targetsIn() to query groups.
 *   Compound specific names (e.g. "date-label", "modal-calendar-grid") are named
 *   individual references — use target() to fetch them once in init().
 */
export default class Component {
    /**
     * @param {HTMLElement} el   Root element with data-component="..."
     * @param {object}      opts Parsed from data attributes + defaults
     */
    constructor(el, opts = {}) {
        this.el = el;
        this.opts = { ...this.constructor.defaults, ...opts };
        this._listeners = [];

        // Store reference on DOM element for DevTools debugging: $0.__component
        el.__component = this;
    }

    // ---------------------------------------------------------------------------
    // Lifecycle — override in subclasses
    // ---------------------------------------------------------------------------

    /** Called after construction. DOM is ready, set up here. */
    init() {}

    /** Called before removal. Clean up listeners, timers, references. */
    destroy() {
        this._listeners.forEach(({ el, event, handler, capture }) => {
            el.removeEventListener(event, handler, capture);
        });
        this._listeners = [];
        delete this.el.__component;
    }

    // ---------------------------------------------------------------------------
    // Target queries — scoped to this.el
    // ---------------------------------------------------------------------------

    /**
     * Find a single target element.
     * Supports space-separated data-target values.
     * Example: this.target('trigger') finds [data-target~="dropdown.trigger"]
     *
     * @param {string} name
     * @returns {HTMLElement|null}
     */
    target(name) {
        return this.el.querySelector(
            `[data-target~="${this.constructor.componentName}.${name}"]`
        );
    }

    /**
     * Find all matching target elements.
     * Supports space-separated data-target values.
     *
     * @param {string} name
     * @returns {HTMLElement[]}
     */
    targets(name) {
        return [...this.el.querySelectorAll(
            `[data-target~="${this.constructor.componentName}.${name}"]`
        )];
    }

    /**
     * Walk up the DOM from el to find the nearest ancestor target of this component.
     * Example: this.closestTarget(btn, 'field') finds the enclosing field container.
     *
     * @param {HTMLElement} el
     * @param {string}      name
     * @returns {HTMLElement|null}
     */
    closestTarget(el, name) {
        return el.closest(
            `[data-target~="${this.constructor.componentName}.${name}"]`
        );
    }

    /**
     * Find a single target element within a specific container (not from root).
     * Useful when scoping a query to a field or section returned by closestTarget.
     *
     * @param {HTMLElement} container
     * @param {string}      name
     * @returns {HTMLElement|null}
     */
    targetIn(container, name) {
        return container.querySelector(
            `[data-target~="${this.constructor.componentName}.${name}"]`
        );
    }

    /**
     * Find all matching target elements within a specific container (not from root).
     *
     * @param {HTMLElement} container
     * @param {string}      name
     * @returns {HTMLElement[]}
     */
    targetsIn(container, name) {
        return [...container.querySelectorAll(
            `[data-target~="${this.constructor.componentName}.${name}"]`
        )];
    }

    // ---------------------------------------------------------------------------
    // Configuration from data attributes
    // ---------------------------------------------------------------------------

    /**
     * Read a component-specific data attribute.
     * For data-dropdown-align="right" on component "dropdown":
     *   this.data('align') → "right"
     *
     * @param {string} key
     * @returns {string|undefined}
     */
    data(key) {
        const prefix = this._camelName();
        const attrKey = prefix + key.charAt(0).toUpperCase() + key.slice(1);
        return this.el.dataset[attrKey];
    }

    // ---------------------------------------------------------------------------
    // Event helpers
    // ---------------------------------------------------------------------------

    /**
     * Emit a custom DOM event that bubbles.
     * Listeners on parent elements or document can catch it.
     *
     * @param {string} eventName
     * @param {object} detail
     */
    emit(eventName, detail = {}) {
        this.el.dispatchEvent(
            new CustomEvent(eventName, {
                bubbles: true,
                detail: { component: this, ...detail },
            })
        );
    }

    /**
     * Add an event listener with automatic cleanup on destroy().
     *
     * @param {HTMLElement|string} elOrSelector  Element or CSS selector (resolved within this.el)
     * @param {string}             event
     * @param {Function}           handler
     * @param {boolean|object}     options
     */
    on(elOrSelector, event, handler, options = false) {
        const target =
            typeof elOrSelector === 'string'
                ? this.el.querySelector(elOrSelector)
                : elOrSelector;
        if (!target) return;
        target.addEventListener(event, handler, options);
        this._listeners.push({
            el: target,
            event,
            handler,
            capture: options,
        });
    }

    // ---------------------------------------------------------------------------
    // Internal helpers
    // ---------------------------------------------------------------------------

    /** Convert kebab-case componentName to camelCase for dataset access. */
    _camelName() {
        return this.constructor.componentName.replace(/-([a-z])/g, (_, c) =>
            c.toUpperCase()
        );
    }

    // ---------------------------------------------------------------------------
    // Static identity — override in every subclass
    // ---------------------------------------------------------------------------

    /** Must match the data-component="..." value (kebab-case). */
    static componentName = 'component';

    /** Default options. Merged with data-attribute values. */
    static defaults = {};
}
