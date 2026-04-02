(() => {
'use strict';

// ── Modal helpers ─────────────────────────────────────────────────────────────

let activePicker = null;

function getModal() {
    return document.querySelector('.iconpicker-modal');
}

function modalOpen(pickerEl) {
    const modal = getModal();
    if (!modal) return;

    activePicker = pickerEl;

    // Aktuellen Wert der Instanz ermitteln → passendes Item als is-active markieren
    const currentValue = pickerEl.querySelector('input[type="hidden"]').value;

    modal.querySelectorAll('.iconpicker-item.is-active')
         .forEach(el => el.classList.remove('is-active'));

    if (currentValue) {
        const active = modal.querySelector(`.iconpicker-item[data-value="${CSS.escape(currentValue)}"]`);
        if (active) active.classList.add('is-active');
    }

    // Suche zurücksetzen, alle Icons einblenden
    const search = modal.querySelector('.iconpicker-search input');
    if (search) search.value = '';
    modal.querySelectorAll('.iconpicker-item').forEach(el => { el.hidden = false; });
    modal.querySelectorAll('.iconpicker-library').forEach(el => { el.hidden = false; });

    modal.hidden = false;
    if (search) search.focus();
}

function modalClose() {
    const modal = getModal();
    if (!modal) return;
    modal.hidden = true;
    activePicker = null;
}

// ── Event delegation ──────────────────────────────────────────────────────────

// "Icon wählen"-Button → Modal öffnen
document.addEventListener('click', (e) => {
    const btn = e.target.closest('.iconpicker-open');
    if (!btn) return;
    const picker = btn.closest('.iconpicker');
    if (!picker) return;
    modalOpen(picker);
});

// Icon-Item im Modal → Wert in Picker-Instanz übernehmen, Modal schließen
document.addEventListener('click', (e) => {
    const item = e.target.closest('.iconpicker-item');
    if (!item) return;

    const modal = getModal();
    if (!modal || modal.hidden) return;

    if (!activePicker) return;

    // Wert setzen
    activePicker.querySelector('input[type="hidden"]').value = item.dataset.value;

    // Vorschau aktualisieren
    const svgEl = item.querySelector('.iconpicker-svg');
    updatePreview(activePicker, item.dataset.icon, svgEl);

    modalClose();
});

// Schließen: Close-Button, Cancel, Backdrop
document.addEventListener('click', (e) => {
    if (e.target.closest('.iconpicker-modal-close') || e.target.closest('.iconpicker-modal-cancel')) {
        modalClose();
        return;
    }
    // Backdrop-Klick (direkt auf .iconpicker-modal-backdrop)
    if (e.target.classList.contains('iconpicker-modal-backdrop')) {
        modalClose();
    }
});

// Escape-Taste
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') modalClose();
});

// Clear-Button
document.addEventListener('click', (e) => {
    if (!e.target.closest('.iconpicker-clear')) return;

    const picker = e.target.closest('.iconpicker');
    if (!picker) return;

    picker.querySelector('input[type="hidden"]').value = '';
    clearPreview(picker);
});

// Suche im Modal
document.addEventListener('input', (e) => {
    if (!e.target.closest('.iconpicker-search')) return;
    const search = e.target;

    const term = search.value.toLowerCase().trim();

    const modal = getModal();
    if (!modal) return;

    modal.querySelectorAll('.iconpicker-library').forEach(lib => {
        let visibleCount = 0;

        lib.querySelectorAll('.iconpicker-item').forEach(item => {
            const match = !term
                || (item.dataset.icon || '').toLowerCase().includes(term)
                || (item.dataset.keywords || '').toLowerCase().includes(term);

            item.hidden = !match;
            if (match) visibleCount++;
        });

        lib.hidden = visibleCount === 0;
    });
});

// ── Helpers ───────────────────────────────────────────────────────────────────

function updatePreview(picker, label, svgEl) {
    picker.querySelector('.iconpicker-current-svg').innerHTML = svgEl ? svgEl.outerHTML : '';
    picker.querySelector('.iconpicker-current-label').textContent = label || '';
    picker.querySelector('.iconpicker-clear').hidden = false;
}

function clearPreview(picker) {
    picker.querySelector('.iconpicker-current-svg').innerHTML = '';
    picker.querySelector('.iconpicker-current-label').textContent = 'Kein Icon gewählt';
    picker.querySelector('.iconpicker-clear').hidden = true;
}

function watchHiddenInput(picker) {
    const input = picker.querySelector('input[type="hidden"]');
    if (!input) return;

    // MutationObserver: greift wenn setAttribute('value', …) aufgerufen wird
    const observer = new MutationObserver(() => {
        updatePickerFromValue(picker);
    });
    observer.observe(input, { attributes: true, attributeFilter: ['value'] });

    // change-Event: greift wenn MBlock input.value = x setzt und dann change triggert
    input.addEventListener('change', () => updatePickerFromValue(picker));
}

function updatePickerFromValue(picker) {
    const value = picker.querySelector('input[type="hidden"]').value;
    if (!value) {
        clearPreview(picker);
        return;
    }

    const modal = getModal();
    if (!modal) return;

    const item = modal.querySelector(`.iconpicker-item[data-value="${CSS.escape(value)}"]`);
    if (!item) return;

    const svgEl = item.querySelector('.iconpicker-svg');

    updatePreview(picker, item.dataset.icon, svgEl);
}

function init(picker) {
    watchHiddenInput(picker);
    updatePickerFromValue(picker);
}

document.querySelectorAll('.iconpicker').forEach(init);

// MBlock: neue Picker-Instanzen initialisieren wenn MBlock eine Zeile hinzufügt
if (typeof jQuery !== 'undefined') {
    jQuery(document).on('rex:ready', function (e, $container) {
        $container.find('.iconpicker').each(function () {
            init(this);
        });
    });
}

})();
