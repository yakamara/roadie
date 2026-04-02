# Roadie Addon

## Widgets

Backend-Widgets für REDAXO-Moduleingaben. Assets werden in `project/boot.php` auf der `content/edit`-Seite geladen.

### IconPicker

Ermöglicht die Auswahl eines Icons aus einer oder mehrerer SVG-Libraries.

```php
use Yakamara\Roadie\Widget\IconPicker;

echo IconPicker::widget('REX_INPUT_VALUE[1]', 'REX_VALUE[1]');
```

**Gespeicherter Wert:** Icon-Name der Default-Library (`arrow_right`) oder `library:name` für weitere Libraries.

**Moduloutput:**

```php
use Yakamara\Roadie\Icons\IconRegistry;

$value = 'REX_VALUE[1]';
$parsed = IconRegistry::parseValue($value);
$icon = IconRegistry::get($parsed['library'], $parsed['name']);
// $icon['svg'] enthält den bereinigten SVG-Markup
```

---

### ColorPicker

Ermöglicht die Auswahl einer vordefinierten Farbe als Key (kein Hex-Wert).

```php
use Yakamara\Roadie\Widget\ColorPicker;

echo ColorPicker::widget('REX_INPUT_VALUE[2]', 'REX_VALUE[2]');
```

**Gespeicherter Wert:** Farb-Key (z.B. `primary`, `transparent`) oder leerer String.

**Farben registrieren** (in `project/boot.php`):

```php
use Yakamara\Roadie\Widget\ColorPicker;

ColorPicker::registerGroup('brand', 'Markenfarben', [
    'primary'   => ['color' => '#003366', 'name' => 'Primärfarbe'],
    'secondary' => ['color' => '#668899', 'name' => 'Sekundärfarbe'],
]);
```

**Moduloutput:**

```php
$colorKey = ColorPicker::validate('REX_VALUE[2]');
$style = $colorKey !== '' ? 'style="--section-color: var(--color-' . $colorKey . ')"' : '';
```

---

## IconRegistry

Zentrale Klasse für Icon-Konfiguration und -Zugriff. Konfiguration erfolgt in `project/boot.php`.

```php
use Yakamara\Roadie\Icons\IconRegistry;

IconRegistry::setDefaultLibrary('material-sharp');   // Ordnername der Default-Library
IconRegistry::setIconsDirectory(rex_path::base('assets/backend/icons')); // Pfad zu den SVG-Ordnern
IconRegistry::setMetaFile('/pfad/zu/icon-meta.json'); // Optional: Labels/Keywords überschreiben
```

**Icon-Meta-Datei** (optional, JSON):

```json
{
  "material-sharp/arrow_right": {
    "label": "Pfeil rechts",
    "keywords": ["pfeil", "weiter", "next"]
  }
}
```

Schlüssel: `library/name` oder nur `name` für alle Libraries.

---

## Console Commands

### `roadie:generate-icon-manifest`

Liest SVG-Dateien aus dem konfigurierten Icons-Verzeichnis und schreibt das Manifest nach `var/data/addons/roadie/icons.json`.

```bash
php bin/console roadie:generate-icon-manifest
```

Voraussetzung: `IconRegistry::setDefaultLibrary()` und `IconRegistry::setIconsDirectory()` sind in `project/boot.php` gesetzt.

---

### `roadie:generate-component-imports`

Scannt Templates, Module und das Project-Addon nach verwendeten `<wa-*>`-Tags und Roadie-Komponenten und generiert `assets/roadie-component-imports.js` für den Webpack-Build.

```bash
php bin/console roadie:generate-component-imports
```

Wird automatisch vor jedem Build aufgerufen (via `package.json`-Scripts `watch`, `build`, `dev-server`). Die generierte Datei nicht manuell bearbeiten.
