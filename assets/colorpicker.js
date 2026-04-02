(() => {
'use strict';

// ── Klick-Handling ─────────────────────────────────────────────────────────

document.addEventListener('click', (e) => {
    const swatch = e.target.closest('.colorpicker-swatch');
    if (!swatch) return;

    const picker = swatch.closest('.colorpicker');
    if (!picker) return;

    const value = swatch.dataset.value;
    picker.querySelector('input[type="hidden"]').value = value;

    picker.querySelectorAll('.colorpicker-swatch').forEach(s => {
        s.setAttribute('aria-pressed', s === swatch ? 'true' : 'false');
    });
});

// ── Initialisierung ────────────────────────────────────────────────────────

function syncActiveState(picker) {
    const value = picker.querySelector('input[type="hidden"]').value;
    picker.querySelectorAll('.colorpicker-swatch').forEach(s => {
        s.setAttribute('aria-pressed', s.dataset.value === value ? 'true' : 'false');
    });
}

function init(picker) {
    const input = picker.querySelector('input[type="hidden"]');
    if (!input) return;

    // Aktiven Zustand nach programmatischer Wertänderung synchronisieren (MBlock)
    input.addEventListener('change', () => syncActiveState(picker));
}

document.querySelectorAll('.colorpicker').forEach(init);

// MBlock: neue Picker-Instanzen initialisieren wenn MBlock eine Zeile hinzufügt
if (typeof jQuery !== 'undefined') {
    jQuery(document).on('rex:ready', function (e, $container) {
        $container.find('.colorpicker').each(function () {
            init(this);
            syncActiveState(this);
        });
    });
}

})();
