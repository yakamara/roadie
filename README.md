# Roadie Addon

---

## Inhaltsverzeichnis

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
- [Console Commands](#console-commands)
- [Utilities](#utilities)

---

## Asset Management

`AssetResolver` liest `manifest.json` und `entrypoints.json` aus dem Webpack-Build und liefert korrekte URLs — auch für den Dev-Server.

```php
use Yakamara\Roadie\Asset\AssetResolver;

$resolver = new AssetResolver();                        // Default: frontend/build/
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

$attrs = new HtmlAttributes(['data-tracking' => 'cta', 'class' => 'my-button']);
echo new Button(label: 'Klick', attributes: $attrs);
```

### Slots

Für zusammengesetzte Inhalte steht `Component::slot()` zur Verfügung:

```php
echo new Dialog(
    content: Component::slot('<p>Inhalt</p>'),
    footer: Component::slot(new Button(label: 'Schließen'), 'footer'),
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

```php
use Yakamara\Roadie\Component\Image\ImageResolution;

echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
    resolutions: new ImageResolution(widths: [400, 800, 1200]),
    sizes: '(max-width: 768px) 100vw, 50vw',
);
```

Breakpoint-spezifische Breiten via `ImageBreakpointValues` (in `project/boot.php` setzen):

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

```php
use Yakamara\Roadie\Component\Image\ImageMotif;

echo new Image(
    imageName: 'REX_MEDIA[1]',
    mediaManagerType: 'my_type',
    motifs: [
        new ImageMotif(mediaMinWidth: 768, imageName: 'REX_MEDIA[2]'),
    ],
);
```

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

### Konfiguration (in `project/boot.php`)

```php
use Yakamara\Roadie\Icons\IconRegistry;

IconRegistry::setDefaultLibrary('material-sharp');
IconRegistry::setIconsDirectory(rex_path::base('assets/backend/icons'));
IconRegistry::setMetaFile('/pfad/zu/icon-meta.json');  // Optional
```

**Icon-Meta-Datei** (optional, überschreibt Labels/Keywords):

```json
{
  "material-sharp/arrow_right": {
    "label": "Pfeil rechts",
    "keywords": ["pfeil", "weiter", "next"]
  }
}
```

### Aliase

Icons aus Nicht-Default-Libraries können mit einem Alias versehen werden, sodass kein `library`-Parameter nötig ist:

```php
IconRegistry::alias('social-facebook', 'facebook', 'project');
// Verwendung: new Icon(name: 'social-facebook')  — library wird automatisch aufgelöst
```

### IconLibrary (Empfehlung für Project-Addons)

Für Projekte empfiehlt sich eine zentrale `IconLibrary`-Klasse, die alle genutzten Icon-Namen als Konstanten bündelt und Library-Aliase registriert. So sind Icon-Namen im Code typsicher und an einer Stelle änderbar.

```php
namespace Yakamara\Project\Icons;

use Yakamara\Roadie\Icons\IconRegistry;

final class IconLibrary
{
    // Navigation
    public const string CLOSE      = 'close';
    public const string HAMBURGER  = 'menu';
    public const string NAV_NEXT   = 'chevron_right';
    public const string NAV_PREV   = 'chevron_left';

    // Social (library: 'project' — eigene SVGs)
    public const string SOCIAL_FACEBOOK  = 'facebook';
    public const string SOCIAL_INSTAGRAM = 'instagram';

    public static function register(): void
    {
        // Aliase für Icons aus Nicht-Default-Libraries
        IconRegistry::alias(self::SOCIAL_FACEBOOK,  'facebook',  'project');
        IconRegistry::alias(self::SOCIAL_INSTAGRAM, 'instagram', 'project');
    }
}
```

Registrierung in `project/boot.php`:

```php
use Yakamara\Project\Icons\IconLibrary;

IconLibrary::register();
```

Verwendung im Code — kein Hardcoding von Icon-Namen:

```php
use Yakamara\Roadie\Component\Icon\Icon;
use Yakamara\Project\Icons\IconLibrary;

echo new Icon(name: IconLibrary::CLOSE);
echo new Icon(name: IconLibrary::SOCIAL_FACEBOOK);  // library wird automatisch per Alias aufgelöst
```

### Icon-Komponente

```php
use Yakamara\Roadie\Component\Icon\Icon;

echo new Icon(name: 'arrow_right');                     // Default-Library
echo new Icon(name: 'facebook', library: 'project');    // Explizite Library
echo new Icon(name: 'social-facebook');                 // Per Alias (kein library nötig)
echo new Icon(name: 'star', label: 'Favorit');          // Mit ARIA-Label
```

### Im Moduloutput

```php
$parsed = IconRegistry::parseValue('REX_VALUE[1]');
$icon   = IconRegistry::get($parsed['library'], $parsed['name']);
// $icon['svg'] enthält bereinigten SVG-Markup
```

---

## Section & Layout

`Section` ist ein Platzhalter-basiertes Wrapper-System für Sektionen. Frontend: Platzhalter `{{{SECTION_...}}}` werden nach dem Rendering durch echte Tags ersetzt. Backend: Platzhalter werden mit `roadie-section`-Klasse umhüllt.

```php
use Yakamara\Roadie\Section\Section;

$section = new Section(
    attributes: ['class' => 'my-section', 'data-variant' => 'brand'],
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

## Console Commands

### `roadie:generate-icon-manifest`

Liest SVG-Dateien aus dem konfigurierten Icons-Verzeichnis und schreibt das Manifest nach `var/data/addons/roadie/icons.json`. SVGs werden dabei bereinigt (Deklarationen, `width`/`height`, Whitespace) und `fill` auf `currentColor` normalisiert.

```bash
php bin/console roadie:generate-icon-manifest
```

Voraussetzung: `IconRegistry::setDefaultLibrary()` und `IconRegistry::setIconsDirectory()` sind in `project/boot.php` gesetzt.

### `roadie:generate-component-imports`

Scannt Templates, Module und das Project-Addon nach verwendeten `<wa-*>`-Tags und Roadie-Komponenten und generiert `assets/roadie-component-imports.js` für den Webpack-Build.

```bash
php bin/console roadie:generate-component-imports
```

Wird automatisch vor jedem Build aufgerufen (via `package.json`-Scripts `watch`, `build`, `dev-server`). Die generierte Datei nicht manuell bearbeiten.

### `roadie:article-key`

Siehe [ArticleKey → Console Command](#console-command).

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
