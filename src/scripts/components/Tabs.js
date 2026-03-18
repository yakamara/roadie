import Component from '../core/Component.js';

/**
 * Tabs component — the simplest example for new team members.
 *
 * HTML:
 *   <div data-component="tabs">
 *     <div role="tablist">
 *       <button data-target="tabs.tab" data-action="click:select"
 *               data-tabs-panel="flights" role="tab" aria-selected="true" tabindex="0">
 *         Flights
 *       </button>
 *       <button data-target="tabs.tab" data-action="click:select"
 *               data-tabs-panel="hotels" role="tab" aria-selected="false" tabindex="-1">
 *         Hotels
 *       </button>
 *     </div>
 *     <div data-target="tabs.panel" data-tabs-panel-id="flights" role="tabpanel">
 *       Flights content...
 *     </div>
 *     <div data-target="tabs.panel" data-tabs-panel-id="hotels" role="tabpanel" hidden>
 *       Hotels content...
 *     </div>
 *   </div>
 */
export default class Tabs extends Component {
  static componentName = 'tabs';
  static defaults = {};

  init() {
    this.tabs = this.targets('tab');
    this.panels = this.targets('panel');

    // Activate first tab or the one with aria-selected="true"
    const active =
      this.tabs.find((t) => t.getAttribute('aria-selected') === 'true') ||
      this.tabs[0];
    if (active) this._activate(active);

    // Arrow key navigation in tablist
    const tablist = this.el.querySelector('[role="tablist"]');
    if (tablist) {
      this.on(tablist, 'keydown', this._onKeydown.bind(this));
    }
  }

  // ---------------------------------------------------------------------------
  // Actions
  // ---------------------------------------------------------------------------

  /** data-action="click:select" on tab buttons */
  select(e, tabEl) {
    e.preventDefault();
    this._activate(tabEl);
  }

  // ---------------------------------------------------------------------------
  // Private
  // ---------------------------------------------------------------------------

  _activate(tabEl) {
    const targetId = tabEl.dataset.tabsPanel;

    this.tabs.forEach((t) => {
      const isActive = t === tabEl;
      t.setAttribute('aria-selected', isActive ? 'true' : 'false');
      t.setAttribute('tabindex', isActive ? '0' : '-1');
    });

    this.panels.forEach((p) => {
      p.hidden = p.dataset.tabsPanelId !== targetId;
    });

    this.emit('tabs:change', { activeTab: tabEl, panelId: targetId });
  }

  _onKeydown(e) {
    const idx = this.tabs.indexOf(e.target);
    if (idx === -1) return;

    let nextIdx;
    switch (e.key) {
      case 'ArrowRight':
        nextIdx = (idx + 1) % this.tabs.length;
        break;
      case 'ArrowLeft':
        nextIdx = (idx - 1 + this.tabs.length) % this.tabs.length;
        break;
      case 'Home':
        nextIdx = 0;
        break;
      case 'End':
        nextIdx = this.tabs.length - 1;
        break;
      default:
        return;
    }

    e.preventDefault();
    this.tabs[nextIdx]?.focus();
    this._activate(this.tabs[nextIdx]);
  }
}
