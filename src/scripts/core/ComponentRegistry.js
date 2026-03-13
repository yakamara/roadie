/**
 * Component Registry
 *
 * Handles:
 *  - Component registration (name → class mapping)
 *  - Auto-initialization of [data-component] elements
 *  - Delegated event handling via [data-action]
 *  - MutationObserver for dynamic DOM changes (auto init/destroy)
 */

// ---------------------------------------------------------------------------
// State
// ---------------------------------------------------------------------------

const registry = new Map();           // componentName → ComponentClass
const instances = new WeakMap();      // element → Map<componentName, instance>
const delegatedEvents = new Set();    // event types with active delegation

// ---------------------------------------------------------------------------
// Registration
// ---------------------------------------------------------------------------

/**
 * Register a component class.
 * @param {typeof import('./Component').default} ComponentClass
 */
export function register(ComponentClass) {
  const name = ComponentClass.componentName;
  if (!name || name === 'component') {
    throw new Error('Component must define a static componentName');
  }
  if (registry.has(name)) {
    console.warn(`[ComponentRegistry] "${name}" already registered. Overwriting.`);
  }
  registry.set(name, ComponentClass);
}

// ---------------------------------------------------------------------------
// Initialization
// ---------------------------------------------------------------------------

/**
 * Initialize all uninitialized components within a root element.
 * @param {HTMLElement} root
 */
export function initAll(root = document.body) {
  root.querySelectorAll('[data-component]').forEach((el) => initElement(el));
}

/**
 * Initialize a single element. Supports multiple components per element:
 * data-component="dropdown tooltip"
 */
function initElement(el) {
  const names = el.dataset.component.trim().split(/\s+/);

  for (const name of names) {
    // Skip if already initialized for this component name
    if (instances.has(el) && instances.get(el).has(name)) continue;

    const ComponentClass = registry.get(name);
    if (!ComponentClass) {
      console.warn(`[ComponentRegistry] No component registered for "${name}"`);
      continue;
    }

    const opts = parseComponentData(el, name);
    const instance = new ComponentClass(el, opts);
    instance.init();

    if (!instances.has(el)) {
      instances.set(el, new Map());
    }
    instances.get(el).set(name, instance);
  }
}

/**
 * Destroy all component instances bound to an element.
 */
function destroyElement(el) {
  const map = instances.get(el);
  if (!map) return;
  for (const instance of map.values()) {
    instance.destroy();
  }
  instances.delete(el);
}

// ---------------------------------------------------------------------------
// Data Attribute Parsing
// ---------------------------------------------------------------------------

/**
 * Parse data-[component]-* attributes into an options object.
 *
 * Example: data-dropdown-align="right" with componentName "dropdown"
 *   → { align: "right" }
 *
 * Handles kebab-case to camelCase conversion automatically via dataset.
 */
function parseComponentData(el, componentName) {
  // Convert kebab-case component name to camelCase prefix for dataset lookup
  const prefix = componentName.replace(/-([a-z])/g, (_, c) => c.toUpperCase());
  const opts = {};

  for (const [key, value] of Object.entries(el.dataset)) {
    // Skip non-prefixed attributes and the 'component' key itself
    if (key === 'component' || key === 'target' || key === 'action') continue;
    if (!key.startsWith(prefix)) continue;

    // Extract option name: "dropdownAlign" → "align"
    const optKey = key.slice(prefix.length);
    if (!optKey) continue;
    const normalizedKey = optKey.charAt(0).toLowerCase() + optKey.slice(1);
    opts[normalizedKey] = value;
  }

  return opts;
}

// ---------------------------------------------------------------------------
// Public API
// ---------------------------------------------------------------------------

/**
 * Get the component instance for an element.
 * @param {HTMLElement} el
 * @param {string} [name] Component name. Required if element has multiple components.
 * @returns {import('./Component').default|undefined}
 */
export function getComponent(el, name) {
  const map = instances.get(el);
  if (!map) return undefined;
  if (name) return map.get(name);
  // Return first (and usually only) instance
  return map.values().next().value;
}

// ---------------------------------------------------------------------------
// Event Delegation
// ---------------------------------------------------------------------------

/**
 * Set up global delegated event handling for data-action attributes.
 *
 * Format: data-action="click:toggle mouseenter:preview"
 *
 * Events bubble up to document.body. The handler:
 *  1. Walks from e.target upward to find data-action matching the event type
 *  2. From that element, walks up to find the nearest data-component ancestor
 *  3. Calls the named method on the component instance
 */
export function setupDelegation() {
  const events = [
    'click',
    'mouseenter',
    'mouseleave',
    'input',
    'change',
    'submit',
    'keydown',
    'keyup',
    'focus',
    'blur',
  ];
  events.forEach((evt) => delegateEvent(evt));
}

function delegateEvent(eventType) {
  if (delegatedEvents.has(eventType)) return;
  delegatedEvents.add(eventType);

  // focus/blur don't bubble — use capture phase
  const useCapture = eventType === 'focus' || eventType === 'blur';

  document.body.addEventListener(
    eventType,
    (e) => {
      let node = e.target;

      while (node && node !== document.body) {
        const actionAttr = node.getAttribute('data-action');
        if (actionAttr) {
          const actions = actionAttr.split(/\s+/);
          for (const action of actions) {
            const colonIdx = action.indexOf(':');
            if (colonIdx === -1) continue;

            const evt = action.slice(0, colonIdx);
            const method = action.slice(colonIdx + 1);

            if (evt === eventType && method) {
              const componentEl = node.closest('[data-component]');
              if (componentEl) {
                const map = instances.get(componentEl);
                if (map) {
                  // Try each component instance on this element
                  for (const instance of map.values()) {
                    if (typeof instance[method] === 'function') {
                      instance[method](e, node);
                      break;
                    }
                  }
                }
              }
            }
          }
        }
        node = node.parentElement;
      }
    },
    useCapture
  );
}

// ---------------------------------------------------------------------------
// MutationObserver — auto init/destroy on DOM changes
// ---------------------------------------------------------------------------

let observer = null;

/**
 * Start observing the DOM for added/removed [data-component] elements.
 * @param {HTMLElement} root
 */
export function observeDOM(root = document.body) {
  if (observer) return;

  observer = new MutationObserver((mutations) => {
    for (const mutation of mutations) {
      for (const node of mutation.addedNodes) {
        if (node.nodeType !== Node.ELEMENT_NODE) continue;
        if (node.hasAttribute('data-component')) initElement(node);
        node.querySelectorAll?.('[data-component]').forEach(initElement);
      }

      for (const node of mutation.removedNodes) {
        if (node.nodeType !== Node.ELEMENT_NODE) continue;
        if (node.hasAttribute('data-component')) destroyElement(node);
        node.querySelectorAll?.('[data-component]').forEach(destroyElement);
      }
    }
  });

  observer.observe(root, { childList: true, subtree: true });
}

/**
 * Stop the MutationObserver.
 */
export function disconnectObserver() {
  if (observer) {
    observer.disconnect();
    observer = null;
  }
}
