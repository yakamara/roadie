# Roadie Addon

![Version](https://img.shields.io/badge/Version-1.0.0--dev-22c55e)
![REDAXO](https://img.shields.io/badge/REDAXO-%3E%3D5.20-d9251d?logo=redaxo&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-%3E%3D8.3-7a86b8?logo=php&logoColor=white)
![WebAwesome](https://img.shields.io/badge/WebAwesome-3.2.1-0ea5e9)
![Yarn](https://img.shields.io/badge/Yarn-Workspaces-2c8ebb?logo=yarn&logoColor=white)

Roadie ist das Frontend-Framework-AddOn für REDAXO. Es liefert ein Komponenten-System, Asset-Management, Icon-System, Media-Pool-Erweiterungen, Backend-Widgets und Utilities — und baut auf **[WebAwesome](https://backers.webawesome.com/)** als Web-Component-Bibliothek auf.

Die genutzte WebAwesome-Version ist in `src/addons/roadie/package.json` deklariert und wird über Yarn Workspaces automatisch bereitgestellt.

---

## Inhaltsverzeichnis

- [Setup](#setup)
- [Asset Management](#asset-management)
- [Komponenten-System](#komponenten-system)
- [Image-Komponente](#image-komponente)
- [Icon-System](#icon-system)
- [Section & Layout](#section--layout)
- [Slice Management](#slice-management)
- [Media Pool Erweiterungen](#media-pool-erweiterungen)
- [ArticleKey](#articlekey)
- [ArticleUsage – Löschschutz](#articleusage--löschschutz)
- [Backend-Widgets](#backend-widgets)
  - [IconPicker](#iconpicker)
  - [ColorPicker](#colorpicker)
  - [LayoutPicker](#layoutpicker)
- [Console Commands](#console-commands)
- [Utilities](#utilities)

---

## Setup

### Voraussetzungen

- REDAXO >= 5.20
- PHP >= 8.3
- Node.js + yarn
- Symfony Webpack Encore (`@symfony/webpack-encore`)

WebAwesome (`@awesome.me/webawesome`) wird **nicht separat installiert** — es ist als Dependency im Roadie-AddOn deklariert (`src/addons/roadie/package.json`) und wird über den Yarn-Workspace-Mechanismus automatisch ins Root-`node_modules` hochgezogen.

### Yarn Workspaces

Die `package.json` im Projektstamm definiert:

```json
"workspaces": [
    "src/addons/*"
]
```

Das bedeutet: Alle AddOns in `src/addons/` werden als Yarn Workspaces behandelt. Ihre `dependencies` landen gemeinsam im Root-`node_modules`. So kann das Roadie-AddOn eigene npm-Abhängigkeiten mitbringen, ohne dass diese manuell im Projekt eingetragen werden müssen.

### Installation

```bash
yarn install
```

### Scripts

```bash
yarn watch                          # Entwicklung mit File-Watcher
yarn dev-server                     # Entwicklung mit Webpack Dev Server (HTTPS)
yarn build                          # Produktions-Build
yarn generate:icon-manifest         # Icon-Manifest neu generieren (nach SVG-Änderungen)
yarn generate:component-imports     # Wird automatisch von watch/dev-server aufgerufen
```

npm-Alternativen:

```bash
npm run watch
npm run dev-server
npm run build
```

`watch` und `dev-server` rufen `roadie:generate-component-imports` automatisch vor dem Build auf.

---

### webpack.config.js

Der Build nutzt Symfony Webpack Encore mit folgenden Entrypoints:

| Entrypoint | Datei | Zweck |
|---|---|---|
| `app` | `assets/app.js` | Frontend — Styles, WebAwesome, Icon-Libraries, SVG-Sprites |
| `backend` | `assets/backend.js` | REDAXO-Backend — Styles, Backend-spezifische WA-Komponenten |

**Wichtige Konfiguration:**

- `assets/icons/` → `public/build/icons/project/` (eigene SVG-Icons)
- `node_modules/@material-symbols/svg-300/sharp/` → `public/build/icons/material-sharp/` (Material Icons)
- `assets/svgs/` → SVG-Sprites via `svg-sprite-loader` (inline `<use>`)
- Webpack-Warning-Filter für WebAwesome Dynamic Imports (bekanntes False-Positive beim statischen Analysieren des WA-Autoloaders)

---

### assets/app.js (Frontend-Entrypoint)

```js
import '@awesome.me/webawesome/dist/styles/webawesome.css';
import '@awesome.me/webawesome/dist/styles/native.css';
import './styles/style.scss';
import './roadie-component-imports';  // Auto-generiert

import '@awesome.me/webawesome/dist/translations/de.js';
import { registerIconLibrary, allDefined } from '@awesome.me/webawesome/dist/webawesome.js';

// Icon-Libraries registrieren
registerIconLibrary('default', {
    resolver: (name) => `/build/icons/material-sharp/${name}.svg`,
    mutator: (svg) => svg.setAttribute('fill', 'currentColor'),
});
registerIconLibrary('project', {
    resolver: (name) => `/build/icons/project/${name}.svg`,
    mutator: (svg) => svg.setAttribute('fill', 'currentColor'),
});

// Warten bis alle WA-Komponenten im DOM registriert sind
(async () => await allDefined())();
```

**`roadie-component-imports.js`** wird automatisch durch `roadie:generate-component-imports` generiert und enthält nur die tatsächlich genutzten WA-Komponenten. Nicht manuell bearbeiten.

---

### assets/backend.js (Backend-Entrypoint)

```js
import '@awesome.me/webawesome/dist/styles/webawesome.css';
import './backend/styles/style.scss';

import '@awesome.me/webawesome/dist/translations/de.js';
import { registerIconLibrary } from '@awesome.me/webawesome/dist/webawesome.js';

// Feste Auswahl an WA-Komponenten für das REDAXO-Backend
import '@awesome.me/webawesome/dist/components/button/button.js';
import '@awesome.me/webawesome/dist/components/icon/icon.js';
// … weitere Backend-Komponenten

registerIconLibrary('default', {
    resolver: name => `/build/icons/material-sharp/${name}.svg`,
});
```

Backend-Komponenten werden nicht auto-generiert, sondern fest eingetragen — nur was das Backend tatsächlich braucht.

---

### project/boot.php — Checkliste

Alles, was Roadie zur Laufzeit benötigt, wird im Project-Addon konfiguriert. Typische `boot.php`:

```php
use Yakamara\Project\Article\ArticleKey;
use Yakamara\Project\Icons\IconLibrary;
use Yakamara\Roadie\Article\ArticleKeyRegistry;
use Yakamara\Roadie\Asset\AssetResolver;
use Yakamara\Roadie\Component\Image\ImageBreakpointValues;
use Yakamara\Roadie\Component\Template;
use Yakamara\Roadie\Icons\IconRegistry;
use Yakamara\Roadie\Section\SectionManager;
use Yakamara\Roadie\Section\SectionVariant;
use Yakamara\Roadie\Widget\ColorPicker;

$addon = rex_addon::get('project');

// 1. Eigene Komponenten-Templates registrieren
Template::addDirectory($addon->getPath('lib/Component/MyComponent/templates'));

// 2. Icon-System konfigurieren
IconRegistry::setDefaultLibrary('material-sharp');
IconRegistry::setIconsDirectory(rex_path::base('assets/backend/icons'));
IconLibrary::register(); // Aliase registrieren

// 3. Bildbreiten & Breakpoints
ImageBreakpointValues::setValues([
    'Sm' => 576,
    'Md' => 768,
    'Lg' => 1280,
    'Xl' => 1440,
]);

// 4. Section-Varianten
SectionManager::registerVariants(
    SectionVariant::Plain,
    SectionVariant::Neutral,
);

// 5. Artikel-Keys
ArticleKeyRegistry::register(ArticleKey::class, 'project');

// 6. Backend-Assets (nur auf content/edit-Seite)
if (rex::isBackend() && is_object(rex::getUser())) {
    if ('content/edit' === rex_be_controller::getCurrentPage()) {
        rex_view::addJsFile(rex_addon::get('roadie')->getAssetsUrl('iconpicker.js'));
        rex_view::addCssFile(rex_addon::get('roadie')->getAssetsUrl('iconpicker.css'));
        rex_view::addJsFile(rex_addon::get('roadie')->getAssetsUrl('colorpicker.js'));
        rex_view::addCssFile(rex_addon::get('roadie')->getAssetsUrl('colorpicker.css'));
    }

    $backendAssets = (new AssetResolver())->getEntrypointFiles('backend');
    foreach ($backendAssets['js'] as $url) {
        rex_view::addJsFile($url, ['defer' => 'defer']);
    }
    foreach ($backendAssets['css'] as $url) {
        rex_view::addCssFile($url);
    }
}
```

---

## Asset Management

`AssetResolver` liest `manifest.json` und `entrypoints.json` aus dem Webpack-Build und liefert korrekte URLs — auch für den Dev-Server.

```php
use Yakamara\Roadie\Asset\AssetResolver;

$resolver = new AssetResolver();                        // Default: public/build/ (rex_path::frontend('build'))
$url      = $resolver->getAssetUrl('app.js');
$files    = $resolver->getEntrypointFiles('backend');   // ['js' => [...], 'css' => [...]]
```

Für Templates gibt es die statische Fassade `Asset`:

```php
use Yakamara\Roadie\Asset\Asset;

echo Asset::url('fonts/my-font.woff2');
echo Asset::preloadFont('fonts/my-font.woff2');          // <link rel="preload">
echo Asset::scriptTags('app');                           // <script>-Tags des Entrypoints
echo Asset::linkTags('app');                             // <link rel="stylesheet">-Tags

// SVG inline einbetten (mit Barrierefreiheits-Attributen)
echo Asset::svgInline('icons/logo.svg', label: 'Logo');
echo Asset::svgInline('icons/deco.svg');                 // aria-hidden="true"

// SVG-Symbol-Referenz (<svg><use>)
echo Asset::svgSymbol('icon-arrow', label: 'Weiter');
```

`svgInline()` setzt automatisch `role="img"` + `aria-label` wenn ein Label angegeben ist, sonst `aria-hidden="true"`.

### Template-Integration

`Asset::scriptTags()` und `Asset::linkTags()` erzeugen die `<script>`- und `<link>`-Tags für den jeweiligen Webpack-Entrypoint. Typische Einbindung im REDAXO-HTML-Template:

```php
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Asset::linkTags('app') ?>
</head>
<body>
    <?= $this->getArticle() ?>
    <?= Asset::scriptTags('app') ?>
</body>
</html>
```

Der `defer`-Wert ist bei `scriptTags()` bereits eingebaut — die Tags werden mit `defer`-Attribut ausgegeben.

---

## Komponenten-System

### Aufbau

Komponenten-Klassen liegen in `lib/Component/{Name}/{Name}.php`, Templates in `lib/Component/{Name}/templates/{Name}.php`. Alle Komponenten erweitern `Component` und sind direkt per `echo` oder in Templates nutzbar.

Template-Verzeichnisse registrieren (in `boot.php`):

```php
use Yakamara\Roadie\Component\Template;

Template::addDirectory($addon->getPath('lib/Component/MyComponent/templates'));
```

### Komponenten verwenden

```php
use Yakamara\Roadie\Component\Button\Button;
use Yakamara\Roadie\Component\Button\ButtonAppearance;
use Yakamara\Roadie\Component\Icon\Icon;

echo new Button(
    label: 'Mehr erfahren',
    href: '/ueber-uns',
    appearance: ButtonAppearance::Accent,
);

echo new Button(
    label: 'Senden',
    start: new Icon(name: 'send'),
);
```

### HTML-Attribute

Alle Komponenten akzeptieren ein `HtmlAttributes`-Objekt für zusätzliche Attribute:

```php
use Yakamara\Roadie\Component\HtmlAttributes;

$attrs = new HtmlAttributes([
    'data-tracking' => 'cta',
    'class'         => 'my-button',
]);

echo new Button(
    label: 'Klick',
    attributes: $attrs,
);
```

### Slots

Für zusammengesetzte Inhalte steht `Component::slot()` zur Verfügung:

```php
echo new Dialog(
    content: Component::slot('<p>Inhalt</p>'),
    footer: Component::slot(
        new Button(label: 'Schließen'),
        'footer',
    ),
);
```

### Html-Closure

Für bedingtes oder dynamisches Rendering innerhalb von Komponenten:

```php
use Yakamara\Roadie\Component\Html;

$content = new Html(function () use ($items) {
    foreach ($items as $item) {
        echo new Card(title: $item->title);
    }
});
```

### Verfügbare Komponenten

| Kategorie | Komponenten |
|---|---|
| Aktion | Button, ButtonGroup, CopyButton |
| Formular | Input, Textarea, NumberInput, Select, Combobox, Listbox, Checkbox, Radio, RadioGroup, Switch, Slider, FileInput |
| Navigation | Breadcrumb, Dropdown, TabGroup, Tree |
| Overlay | Dialog, Drawer, Popup, Popover, Tooltip |
| Anzeige | Card, Callout, Details, Divider, Avatar, Badge, Tag, Scroller |
| Feedback | Spinner, Skeleton, ProgressBar, ProgressRing, Rating |
| Medien | Image, AnimatedImage, Animation, Carousel, Comparison, ZoomableFrame |
| Formatierung | FormatDate, FormatNumber, FormatBytes, RelativeTime |
| Sonstiges | Icon, Link, Page, SplitPanel, QrCode, Sparkline, ColorPicker |

---

## Image-Komponente

Erzeugt barrierefreie `<picture>`-Elemente mit responsiven Bildbreiten, Formatkonvertierung und optionaler Bildunterschrift.

```php
use Yakamara\Roadie\Component\Image\Image;

echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
);
```

### Responsive Breiten

`ImageResolution` ist ein Enum mit vier Stufen, die jeweils vordefinierte Pixelbreiten abdecken:

| Case | Standardwerte |
|---|---|
| `ImageResolution::Small` | 200, 400, 800 |
| `ImageResolution::Medium` | 1200, 1600 |
| `ImageResolution::Large` | 1920, 2400 |
| `ImageResolution::All` | alle obigen kombiniert |

```php
use Yakamara\Roadie\Component\Image\ImageResolution;

echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
    resolutions: ImageResolution::Medium,
    sizes: '(max-width: 768px) 100vw, 50vw',
);
```

Alternativ kann ein eigenes Breiten-Array übergeben werden:

```php
resolutions: [400, 800, 1200],
```

Die Standardwerte der Enum-Cases können projektspezifisch überschrieben werden (in `project/boot.php`):

```php
use Yakamara\Roadie\Component\Image\ImageResolutionValues;

ImageResolutionValues::setValues([
    'Small' => [200, 400, 800],
    'Medium' => [1200, 1600],
    'Large' => [1920, 2400],
]);
```

### Setup: MediaManager-Effect und .htaccess

Die `Image`-Komponente erzeugt URLs der Form `images/{type}/datei@200w.webp`. Damit diese funktionieren, sind zwei Voraussetzungen nötig:

**1. `.htaccess` — Rewrite-Regel für responsive Images**

Im Projektverzeichnis muss folgende Regel eingetragen sein (der Kommentar markiert den Separator `@`):

```apache
# -roadie- = Separator for responsive images
RewriteRule ^images/([^/]*)/(([^/]*)@?([0-9]*)w?\.(jpeg|jpg|avif|webp|png)) %{ENV:BASE}/index.php?rex_media_type=$1&rex_media_file=$2&roadie=true&%{QUERY_STRING} [B]
```

**2. MediaManager — `roadie_responsive`-Effect**

In jedem genutzten Medientyp muss der Effect `roadie_responsive` (`rex_effect_roadie_responsive`) als **erster Effect** eingetragen sein. Er liest Breite (`@200w`) und Format (`.webp`) aus dem Dateinamen und überschreibt damit die konfigurierten Effekt-Parameter aller nachfolgenden Effekte zur Laufzeit — nur wenn `?roadie=true` im Request gesetzt ist.

> **Wichtig:** Steht der Effect nicht an erster Stelle, greifen die nachfolgenden Resize-/Format-Effekte vor der Anpassung und der responsive Mechanismus funktioniert nicht korrekt.

URL-Schema:
- `datei@200w.jpg` → Originaldatei in 200 px Breite, JPEG
- `datei.jpg@200w.webp` → Originaldatei in 200 px Breite, konvertiert zu WebP

Erlaubte Breiten werden über `ImageResolutionValues` validiert — nur registrierte Werte werden akzeptiert, sonst wird keine Größenanpassung vorgenommen.

**3. FocusPoint (empfohlen)**

Das AddOn `focuspoint` (FriendsOfREDAXO) ermöglicht es, am Medium im Backend einen Fokuspunkt zu definieren. Statt des Standard-`resize`-Effects wird dann `focuspoint_fit` genutzt: Er schneidet das Bild so zu, dass der markierte Fokuspunkt immer im sichtbaren Bereich bleibt.

Typische Effekt-Reihenfolge in einem Medientyp:

1. `roadie_responsive` ← **muss an erster Stelle stehen**
2. `focuspoint_fit` (Breite + Höhe, Zoom nach Bedarf) — oder `resize` wenn kein Zuschnitt nötig
3. `image_format` (optional, für AVIF/WebP-Konvertierung)

---

### Breakpoint-Konfiguration

Viewport-Breakpoints für `ImageBreakpointValues` in `project/boot.php` setzen:

```php
use Yakamara\Roadie\Component\Image\ImageBreakpointValues;

ImageBreakpointValues::setValues([
    'Sm' => 576,
    'Md' => 768,
    'Lg' => 1280,
    'Xl' => 1440,
]);
```

Keys müssen PascalCase sein — Lowercase wird stillschweigend ignoriert.

### Art Direction (Motifs)

`ImageMotif` definiert ein alternatives Bild ab einem bestimmten Breakpoint. `fromBreakpoint` erwartet einen `ImageBreakpoint`-Enum-Case (`Xs`, `Sm`, `Md`, `Lg`, `Xl`).

```php
use Yakamara\Roadie\Component\Image\ImageBreakpoint;
use Yakamara\Roadie\Component\Image\ImageMotif;

echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
    motifs: [
        new ImageMotif(
            mediaManagerType: 'landscape',
            fromBreakpoint: ImageBreakpoint::Md,
        ),
        new ImageMotif(
            mediaManagerType: 'wide',
            fromBreakpoint: ImageBreakpoint::Lg,
            resolutions: ImageResolution::Large,  // überschreibt globale resolutions
        ),
    ],
);
```

> **Hinweis:** `ImageMotif` hat kein `imageName`-Parameter — der Dateiname kommt immer vom `imageName` der übergeordneten `Image`-Komponente. Nur der `mediaManagerType` (Seitenverhältnis, Zuschnitt) wechselt.

### Bildformate

```php
echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
    formats: ['avif', 'webp'],   // Fallback: Original-Format
);
```

### Figure mit Caption und Copyright

```php
echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
    figure: true,
    caption: true,       // Aus Media-Metadaten
    copyright: true,     // Aus Media-Metadaten
);
```

---

## Icon-System

Das Icon-System besteht aus drei Schichten: **SVG-Dateien** auf der Festplatte → **Manifest** als optimierter Cache → **Registry** als Laufzeit-API. [IconPicker](#iconpicker-1) und [`Icon`-Komponente](#icon-komponente) greifen beide auf dieselbe Registry zu.

```
assets/backend/icons/
├── material-sharp/        ← Default-Library
│   ├── arrow_right.svg
│   └── close.svg
└── project/               ← Weitere Libraries (z. B. eigene SVGs)
    ├── facebook.svg
    └── instagram.svg
```

Jeder Unterordner ist eine Library. Der Name der Default-Library wird via `setDefaultLibrary()` konfiguriert.

---

### Konfiguration (in `project/boot.php`)

```php
use Yakamara\Roadie\Icons\IconRegistry;

IconRegistry::setDefaultLibrary('material-sharp');
IconRegistry::setIconsDirectory(rex_path::base('assets/backend/icons'));
IconRegistry::setMetaFile(rex_path::base('assets/backend/icons/meta.json'));  // Optional
```

---

### Manifest erstellen

Das Manifest (`var/data/addons/roadie/icons.json`) wird aus den SVG-Dateien generiert und von der Registry gecacht. Nach jeder Änderung an SVG-Dateien neu ausführen:

```bash
php bin/console roadie:generate-icon-manifest
```

SVGs werden automatisch bereinigt: `width`/`height` entfernt, `fill` auf `currentColor` normalisiert, Whitespace komprimiert. Vollständige Dokumentation unter [Console Commands → roadie:generate-icon-manifest](#roadiegenerate-icon-manifest).

**Optionale Meta-Datei** für Labels und Suchbegriffe im IconPicker:

```json
{
    "arrow_right":      { "label": "Pfeil rechts", "keywords": ["navigation", "weiter"] },
    "project/facebook": { "label": "Facebook",     "keywords": ["social"] }
}
```

Keys ohne Library-Präfix gelten für die Default-Library, mit `library/name`-Präfix für weitere Libraries.

---

### Aliase

Icons aus Nicht-Default-Libraries können mit einem Alias versehen werden, sodass kein `library`-Parameter im PHP-Code nötig ist:

```php
IconRegistry::alias('social-facebook', 'facebook', 'project');
// Verwendung: new Icon(name: 'social-facebook') — library wird automatisch aufgelöst
```

---

### IconLibrary (Empfehlung für Project-Addons)

Zentrale Klasse mit allen genutzten Icon-Namen als Konstanten. Verhindert Hardcoding von Strings, macht Umbenennen trivial und registriert Aliase an einer Stelle.

```php
namespace Yakamara\Project\Icons;

use Yakamara\Roadie\Icons\IconRegistry;

final class IconLibrary
{
    // Navigation
    public const string CLOSE     = 'close';
    public const string HAMBURGER = 'menu';
    public const string NAV_NEXT  = 'chevron_right';
    public const string NAV_PREV  = 'chevron_left';

    // Social (library: 'project' — eigene SVGs)
    public const string SOCIAL_FACEBOOK  = 'social-facebook';
    public const string SOCIAL_INSTAGRAM = 'social-instagram';

    public static function register(): void
    {
        IconRegistry::alias(self::SOCIAL_FACEBOOK,  'facebook',  'project');
        IconRegistry::alias(self::SOCIAL_INSTAGRAM, 'instagram', 'project');
    }
}
```

Registrierung in `project/boot.php`:

```php
IconLibrary::register();
```

---

### Icon-Komponente

```php
use Yakamara\Roadie\Component\Icon\Icon;
use Yakamara\Project\Icons\IconLibrary;

// Default-Library
echo new Icon(
    name: IconLibrary::CLOSE,
);

// Per Alias — kein library-Parameter nötig
echo new Icon(
    name: IconLibrary::SOCIAL_FACEBOOK,
);

// Explizite Library
echo new Icon(
    name: 'facebook',
    library: 'project',
);

// Mit ARIA-Label (aria-label + role="img")
echo new Icon(
    name: 'star',
    label: 'Favorit',
);
```

Ohne `label` wird `aria-hidden="true"` gesetzt.

---

### IconPicker (Redakteursauswahl im Backend)

Der [IconPicker](#iconpicker-1) zeigt alle Libraries aus dem Manifest in einem modalen Dialog an. Der gespeicherte Wert ist `icon-name` (Default-Library) oder `library:icon-name`.

```php
// Im Modul-Input:
echo IconPicker::widget('REX_INPUT_VALUE[1]', 'REX_VALUE[1]');

// Im Modul-Output — Icon-Komponente löst library:name automatisch auf:
if ($value = 'REX_VALUE[1]') {
    echo new Icon(name: $value);
}
```

Weitere Details unter [Backend-Widgets → IconPicker](#iconpicker-1).

---

## Section & Layout

`Section` ist ein Platzhalter-basiertes Wrapper-System für Sektionen. Frontend: Platzhalter `{{{SECTION_...}}}` werden nach dem Rendering durch echte Tags ersetzt. Backend: Platzhalter werden mit `roadie-section`-Klasse umhüllt.

```php
use Yakamara\Roadie\Section\Section;

$section = new Section(
    attributes: [
        'class'        => 'my-section',
        'data-variant' => 'brand',
    ],
    tag: 'section',
    innerAttributes: ['class' => 'container'],
);

echo $section->getPlaceholder();  // {{{SECTION_xxxxxx}}} — Öffnender Tag
// ... Slice-Inhalt ...
echo '</div></section>';           // Schließender Tag manuell setzen
```

### Section-Varianten

Registrierung verfügbarer Varianten (in `project/boot.php`):

```php
use Yakamara\Roadie\Section\SectionManager;
use Yakamara\Roadie\Section\SectionVariant;

SectionManager::registerVariants(
    SectionVariant::Plain,
    SectionVariant::Neutral,
);
```

Aktuelle Variante im Slice-Output lesen:

```php
$manager = SectionManager::getInstance()->init();
$variant = $manager->getCurrentVariant();  // SectionVariant::Plain

if ($manager->is(SectionVariant::Neutral)) {
    // Neutrale Gestaltung
}
```

---

## Slice Management

`SliceManager` verwaltet die Überschriften-Hierarchie innerhalb von Artikel-Slices und verhindert doppelte `<h1>`-Tags.

```php
use Yakamara\Roadie\Slice\SliceManager;
use Yakamara\Roadie\Slice\SliceType;

$manager = SliceManager::getInstance()->init();
$manager->setCurrentSliceType($slice, SliceType::NEW_SECTION);

// Heading-Tag für die aktuelle Tiefe ermitteln
$tag = $manager->getHeadingTag();  // 'h1', 'h2', …

// Heading rendern
echo $manager->renderHeading('Mein Titel');
echo $manager->renderHeading('Mein Titel', ['class' => 'headline']);

// HTML mit angepassten Heading-Levels ausgeben
echo $manager->processHtml($htmlWithHeadings);
```

**Slice-Typen:**

| Typ | Bedeutung |
|---|---|
| `NEW_SECTION` | Beginnt einen neuen Abschnitt auf gleicher Ebene |
| `SUB_SECTION` | Beginnt einen Unterabschnitt (Tiefe +1) |
| `CONTINUATION` | Fortsetzung des aktuellen Abschnitts (gleiche Tiefe) |

---

## Media Pool Erweiterungen

Roadie erweitert den REDAXO Media Pool um sprachspezifische Metadaten-Felder.

### Metadaten-Felder (Backend)

Im Medien-Formular werden automatisch folgende Felder ergänzt:

- **Alt-Text** pro Sprache (`med_alt`, `med_alt_2`, …)
- **Bildunterschrift** pro Sprache (`med_caption`, `med_caption_2`, …)
- **Copyright**
- **Dekorativ**-Toggle (überspringt Alt-Text-Pflicht)

### Media-Klasse

`Yakamara\Roadie\MediaPool\Media` ist ein typsicherer Wrapper um `rex_media`:

```php
use Yakamara\Roadie\MediaPool\Media;

$media = Media::get('image.jpg');

$media->getAlt();          // Sprachspezifisch
$media->getCaption();      // Sprachspezifisch
$media->getCopyright();
$media->isDecorative();
$media->getDimensions();                             // [width, height]
$media->getDimensionsByMediaManagerType('my_type'); // [width, height] nach Effekt
```

---

## ArticleKey

Ermöglicht projektweit eindeutige Bezeichner für wichtige Artikel (Impressum, Startseite, Team …), die unabhängig von der Artikel-ID sind. Werte werden in `rex_config` gespeichert und können per Console-Command oder Backend-UI gepflegt werden.

### Enum definieren (im Project-Addon)

```php
namespace Yakamara\Project\Article;

enum ArticleKey: string
{
    case Imprint  = 'imprint';
    case Team     = 'team';
    case Contact  = 'contact';
}
```

### Registrieren (in `project/boot.php`)

```php
use Yakamara\Project\Article\ArticleKey;
use Yakamara\Roadie\Article\ArticleKeyRegistry;

ArticleKeyRegistry::register(ArticleKey::class, 'project');
```

Der zweite Parameter ist der `rex_config`-Namespace (identisch mit dem Addon-Namen).

### Artikel auflösen

```php
use Yakamara\Project\Article\ArticleKey;
use Yakamara\Roadie\Article\ArticleResolver;

$article = ArticleResolver::get(ArticleKey::Imprint);
$url     = ArticleResolver::getUrl(ArticleKey::Imprint);
$urlDe   = ArticleResolver::getUrl(ArticleKey::Imprint, clang: 1);
```

`getUrl()` gibt `'#'` zurück, wenn kein Artikel hinterlegt ist.

### Artikel-Keys setzen / entfernen

```php
ArticleResolver::set(ArticleKey::Imprint, articleId: 42);
ArticleResolver::remove(ArticleKey::Imprint);
```

### Backend-UI

Die Pflegeseite ist im Backend unter **System → Roadie → Artikel-Keys** erreichbar. Alle registrierten Enums werden dort mit einem Linkmap-Feld angezeigt.

### Console Command

```bash
php bin/console roadie:article-key list
php bin/console roadie:article-key set imprint 42
php bin/console roadie:article-key remove imprint
```

Sind mehrere Enums mit gleichem Key-Wert registriert, wird ein Fehler mit den betroffenen Namespaces ausgegeben.

### Löschschutz

Solange ein Artikel einem Key zugewiesen ist, kann er nicht gelöscht werden. Das gilt auch für das Löschen der übergeordneten Kategorie.

---

## ArticleUsage – Löschschutz

Verhindert das Löschen von Artikeln, die noch referenziert werden. Die Prüfung greift auf `ART_PRE_DELETED`, das sowohl beim direkten Artikel-Löschen als auch beim Löschen einer Kategorie ausgelöst wird.

Roadie registriert automatisch folgende Checker:

| Checker | Prüft |
|---|---|
| `ArticleSliceUsageChecker` | `link1`–`link10` und `linklist1`–`linklist10` in `rex_article_slice` |
| `MetaInfoUsageChecker` | REX_LINK_WIDGET- und REX_LINKLIST_WIDGET-Felder in `rex_article` |
| `ArticleKeyUsageChecker` | Alle via `ArticleKeyRegistry` registrierten Enum-Keys |

### Eigene Checker registrieren

```php
use Yakamara\Roadie\ArticleUsage\ArticleUsageChecker;

ArticleUsageChecker::addChecker(static function (int $articleId): array {
    $usages = [];
    // Prüflogik …
    if ($found) {
        $usages[] = 'Wird in Komponente X verwendet';
    }
    return $usages;
});
```

Der Callable erhält die Artikel-ID und gibt eine Liste von menschenlesbaren Verwendungs-Beschreibungen zurück.

---

## Backend-Widgets

Assets werden in `project/boot.php` auf der `content/edit`-Seite geladen:

```php
if (rex::isBackend() && 'content/edit' === rex_be_controller::getCurrentPage()) {
    rex_view::addJsFile(rex_addon::get('roadie')->getAssetsUrl('iconpicker.js'));
    rex_view::addCssFile(rex_addon::get('roadie')->getAssetsUrl('iconpicker.css'));
    rex_view::addJsFile(rex_addon::get('roadie')->getAssetsUrl('colorpicker.js'));
    rex_view::addCssFile(rex_addon::get('roadie')->getAssetsUrl('colorpicker.css'));
}
```

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

$parsed = IconRegistry::parseValue('REX_VALUE[1]');
$icon   = IconRegistry::get($parsed['library'], $parsed['name']);
// $icon['svg'] enthält den bereinigten SVG-Markup
```

### ColorPicker

Ermöglicht die Auswahl einer vordefinierten Farbe als Key (kein Hex-Wert).


```php
use Yakamara\Roadie\Widget\ColorPicker;

echo ColorPicker::widget('REX_INPUT_VALUE[2]', 'REX_VALUE[2]');
```

**Gespeicherter Wert:** Farb-Key (z.B. `primary`, `transparent`) oder leerer String.

**Farben registrieren** (in `project/boot.php`):

```php
ColorPicker::registerGroup(
    group: 'brand',
    label: 'Markenfarben',
    colors: [
        'primary'   => ['color' => '#003366', 'name' => 'Primärfarbe'],
        'secondary' => ['color' => '#668899', 'name' => 'Sekundärfarbe'],
    ],
);
```

**Moduloutput:**

```php
$colorKey = ColorPicker::validate('REX_VALUE[2]');
```

Der Farb-Key wird typischerweise als `data-*`-Attribut ans Element übergeben und per CSS ausgewertet — kein `style`-Attribut, da CSP keine Inline-Styles erlaubt:

```php
// Ausgabe im Template:
echo '<section data-color="' . rex_escape($colorKey) . '">';

// CSS:
// [data-color="primary"] { --section-color: var(--color-primary); }
```

### LayoutPicker

Ermöglicht die visuelle Auswahl eines Layouts anhand von SVG-Vorschauen. Rendert eine `wa-radio-group` mit je einem `wa-radio appearance="button"` pro Option.

```php
use Yakamara\Roadie\Widget\LayoutPicker\LayoutPicker;
use Yakamara\Roadie\Widget\LayoutPicker\LayoutPickerOption;

echo new LayoutPicker(
    options: [
        new LayoutPickerOption(
            value: '1col',
            label: '1-spaltig',
            svg: LayoutPickerSvg::build([
                new LayoutPickerSvgBlock(
                    col: 1,
                    span: 12,
                ),
            ]),
        ),
        new LayoutPickerOption(
            value: '2col',
            label: '2-spaltig',
            svg: LayoutPickerSvg::build([
                new LayoutPickerSvgBlock(
                    col: 1,
                    span: 6,
                ),
                new LayoutPickerSvgBlock(
                    col: 7,
                    span: 6,
                ),
            ]),
        ),
    ],
    name: 'REX_INPUT_VALUE[3]',
    value: 'REX_VALUE[3]',
);
```

**Gespeicherter Wert:** Der `value`-String der gewählten Option (z.B. `2col`).

**SVG-Helfer:**

`LayoutPickerSvg::build()` generiert SVG-Vorschauen auf Basis eines 12-Spalten-Rasters. Das SVG ist immer 100 Einheiten breit, die Höhe ist variabel. Spalten und Blöcke verwenden `currentColor` und passen sich damit automatisch ans CSS-Farbschema an.

```php
use Yakamara\Roadie\Widget\LayoutPicker\LayoutPickerSvgBlock;
use Yakamara\Roadie\Widget\LayoutPicker\LayoutPickerSvg;

// Vollbreite
LayoutPickerSvg::build([
    new LayoutPickerSvgBlock(
        col: 1,
        span: 12,
    ),
]);

// Zwei gleiche Spalten
LayoutPickerSvg::build([
    new LayoutPickerSvgBlock(
        col: 1,
        span: 6,
    ),
    new LayoutPickerSvgBlock(
        col: 7,
        span: 6,
    ),
]);

// Sidebar-Layout mit Header, größere Höhe
LayoutPickerSvg::build(
    blocks: [
        new LayoutPickerSvgBlock(
            col: 1,
            span: 12,
            height: 0.2,
        ),
        new LayoutPickerSvgBlock(
            col: 1,
            span: 3,
            height: 0.8,
            y: 0.2,
        ),
        new LayoutPickerSvgBlock(
            col: 4,
            span: 9,
            height: 0.8,
            y: 0.2,
        ),
    ],
    height: 48,
);
```

`LayoutPickerSvgBlock`-Parameter:

| Parameter | Typ | Bedeutung |
|---|---|---|
| `col` | `int` | Startspalte, 1-basiert (1–12) |
| `span` | `int` | Spaltenbreite (1–12) |
| `height` | `float` | Höhe als Anteil der verfügbaren Höhe (0.0–1.0), Standard `1.0` |
| `y` | `float` | Vertikaler Versatz als Anteil (0.0–1.0), Standard `0.0` |

**Moduloutput:**

```php
$layout = 'REX_VALUE[3]' ?: '1col';
```

**Styling:** Über `.layout-picker`, `.layout-picker--option` und `.layout-picker--label`. SVG-Größe z.B. via `.layout-picker wa-radio svg { width: 4rem; height: auto; }`.

---

## Console Commands

### `roadie:generate-icon-manifest`

Liest alle SVG-Dateien aus dem konfigurierten Icons-Verzeichnis und schreibt das Manifest nach `var/data/addons/roadie/icons.json`.

```bash
php bin/console roadie:generate-icon-manifest
```

**Voraussetzung:** `IconRegistry::setDefaultLibrary()` und `IconRegistry::setIconsDirectory()` sind in `project/boot.php` gesetzt.

**Verzeichnisstruktur:** Jeder Unterordner im Icons-Verzeichnis wird als eigene Library behandelt. Der Ordnername entspricht dem Library-Namen. Der über `setDefaultLibrary()` konfigurierte Ordner wird als Default markiert — Icons daraus werden ohne Library-Präfix gespeichert.

```
assets/backend/icons/
└── material-sharp/     ← Default-Library ("material-sharp")
    ├── arrow-right.svg
    └── close.svg
```

**SVG-Bereinigung:** Jede Datei wird automatisch normalisiert:
- XML-Deklaration, DOCTYPE und Kommentare werden entfernt
- `<title>` und `<desc>` werden entfernt
- `width`/`height`-Attribute am `<svg>`-Tag werden entfernt (Sizing via CSS)
- `fill="*"` wird auf `fill="currentColor"` gesetzt (`fill="none"` bleibt erhalten)
- Whitespace wird normalisiert

**Optionale Meta-Datei** für Labels und Suchbegriffe (via `IconRegistry::setMetaFile()`):

```json
{
    "arrow-right": { "label": "Pfeil rechts", "keywords": ["navigation", "weiter"] },
    "material-sharp/close": { "label": "Schließen", "keywords": ["x", "entfernen"] }
}
```

Ohne Meta-Datei wird der Dateiname als Label verwendet (`arrow-right` → „Arrow Right").

---

### `roadie:generate-component-imports`

Scannt das gesamte Projekt nach verwendeten `<wa-*>`-Tags und Roadie-Komponenten und generiert `assets/roadie-component-imports.js` für den Webpack-Build.

```bash
php bin/console roadie:generate-component-imports
```

**Wird automatisch aufgerufen** vor jedem Build via `package.json`-Scripts (`watch`, `build`, `dev-server`). Die generierte Datei nicht manuell bearbeiten.

**Gescannte Verzeichnisse:**
- `src/templates/` — REDAXO-Templates
- `src/modules/` — REDAXO-Module
- `src/addons/project/` — Project-Addon (PHP-Klassen, Templates)
- `assets/scripts/components/` — Projektspezifische JS-Komponenten

**Was generiert wird:**

| Quelle | Ergebnis |
|---|---|
| `<wa-button>` in PHP/HTML | `import '@awesome.me/webawesome/dist/components/button/button.js'` |
| `use Yakamara\Roadie\Component\Button\Button` | SCSS aus `lib/Component/Button/styles/` + JS aus `lib/Component/Button/scripts/` |
| JS-Klasse mit `static componentName` in `assets/scripts/components/` | `register(MyComponent)` im ComponentRegistry |

Wenn `rex_yform` im Code erkannt wird, werden zusätzlich alle `src/addons/*/ytemplates/roadie/`-Verzeichnisse nach `<wa-*>`-Tags gescannt.

**`wa-*`-Tags ohne entsprechendes Package** (nicht in `node_modules/@awesome.me/webawesome/dist/components/`) werden als Warnung ausgegeben, aber nicht importiert.

---

### `roadie:article-key`

Verwaltet die Zuordnung von Artikel-Keys zu REDAXO-Artikeln auf der Kommandozeile.

```bash
# Alle gesetzten Keys auflisten
php bin/console roadie:article-key list

# Einen Key setzen
php bin/console roadie:article-key set imprint 42

# Einen Key entfernen
php bin/console roadie:article-key remove imprint
```

Sind mehrere Enums mit gleichem Key-Wert registriert, wird ein Fehler mit den betroffenen Namespaces ausgegeben. Weitere Details unter [ArticleKey](#articlekey).

---

## Utilities

### Aria

Erzeugt eindeutige, ARIA-konforme IDs für `id`/`aria-labelledby`-Verknüpfungen:

```php
use Yakamara\Roadie\Util\Aria;

$id = Aria::id();      // z. B. "g4a3f7b2c"  (beginnt immer mit einem Buchstaben)
$id = Aria::lastId();  // Letzte generierte ID wiederverwenden
```

### Locale

Setzt die PHP-Locale anhand der REDAXO-Spracheinstellungen (`clang_locale`, `clang_setlocale`):

```php
use Yakamara\Roadie\Util\Locale;

Locale::setDefault();
```

### FileTypeDetector

Prüft Dateitypen anhand von Extension und MIME-Typ:

```php
use Yakamara\Roadie\Util\FileTypeDetector;

$detector = new FileTypeDetector('/pfad/zur/datei.jpg');

$detector->exists();
$detector->isRasterImage();  // avif, bmp, gif, jpeg, jpg, png, webp
$detector->isSvg();
$detector->isAudio();        // aac, flac, mp3, ogg, wav, webm
$detector->isVideo();        // avi, mov, mp4, mpeg, ogg, webm
$detector->getMimeType();
```

### EnumToArrayTrait

Hilfstrait für `BackedEnum`-Klassen:

```php
use Yakamara\Roadie\Trait\EnumToArrayTrait;

enum MyEnum: string {
    use EnumToArrayTrait;
    case Foo = 'foo';
    case Bar = 'bar';
}

MyEnum::values();        // ['foo', 'bar']
MyEnum::names();         // ['Foo', 'Bar']
MyEnum::arrayByValues(); // ['foo' => <MyEnum::Foo>, 'bar' => <MyEnum::Bar>]
MyEnum::arrayByNames();  // ['Foo' => <MyEnum::Foo>, 'Bar' => <MyEnum::Bar>]
```
