/**
 * Simple Pub/Sub EventBus for cross-component communication.
 *
 * Use this when two components need to talk but have no DOM relationship
 * (i.e. neither is an ancestor/descendant of the other).
 *
 * For parent/child communication, prefer Component.emit() (native CustomEvents).
 *
 * Usage:
 *   import { EventBus } from '../core/EventBus.js';
 *
 *   // Subscribe (returns unsubscribe function)
 *   const off = EventBus.on('search:results', (data) => { ... });
 *
 *   // Publish
 *   EventBus.emit('search:results', { items: [...] });
 *
 *   // Unsubscribe
 *   off();
 */

const listeners = new Map();

export const EventBus = {
  /**
   * Subscribe to an event.
   * @param {string}   event
   * @param {Function} callback
   * @returns {Function} Unsubscribe function
   */
  on(event, callback) {
    if (!listeners.has(event)) listeners.set(event, new Set());
    listeners.get(event).add(callback);
    return () => listeners.get(event)?.delete(callback);
  },

  /**
   * Emit an event with optional data.
   * @param {string} event
   * @param {*}      data
   */
  emit(event, data) {
    listeners.get(event)?.forEach((cb) => cb(data));
  },

  /**
   * Unsubscribe a specific callback.
   * @param {string}   event
   * @param {Function} callback
   */
  off(event, callback) {
    listeners.get(event)?.delete(callback);
  },
};
