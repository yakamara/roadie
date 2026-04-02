<?php

// use Yakamara\Roadie\Component\Image\LowQualityImagePlaceholder;
use Yakamara\Roadie\Component\Template;
use Yakamara\Roadie\MediaPool\MediaExtension;

// use Yakamara\Roadie\View\Notification;
// use Yakamara\Roadie\View\Section;

$addon = rex_addon::get('roadie');

Template::addDirectory($addon->getPath('lib/Component/AnimatedImage/templates'));
Template::addDirectory($addon->getPath('lib/Component/Animation/templates'));
Template::addDirectory($addon->getPath('lib/Component/Avatar/templates'));
Template::addDirectory($addon->getPath('lib/Component/Badge/templates'));
Template::addDirectory($addon->getPath('lib/Component/Breadcrumb/templates'));
Template::addDirectory($addon->getPath('lib/Component/Button/templates'));
Template::addDirectory($addon->getPath('lib/Component/ButtonGroup/templates'));
Template::addDirectory($addon->getPath('lib/Component/Callout/templates'));
Template::addDirectory($addon->getPath('lib/Component/Card/templates'));
Template::addDirectory($addon->getPath('lib/Component/Carousel/templates'));
Template::addDirectory($addon->getPath('lib/Component/Checkbox/templates'));
Template::addDirectory($addon->getPath('lib/Component/ColorPicker/templates'));
Template::addDirectory($addon->getPath('lib/Component/Combobox/templates'));
Template::addDirectory($addon->getPath('lib/Component/Comparison/templates'));
Template::addDirectory($addon->getPath('lib/Component/CopyButton/templates'));
Template::addDirectory($addon->getPath('lib/Component/Details/templates'));
Template::addDirectory($addon->getPath('lib/Component/Dialog/templates'));
Template::addDirectory($addon->getPath('lib/Component/Divider/templates'));
Template::addDirectory($addon->getPath('lib/Component/Drawer/templates'));
Template::addDirectory($addon->getPath('lib/Component/Dropdown/templates'));
Template::addDirectory($addon->getPath('lib/Component/FileInput/templates'));
Template::addDirectory($addon->getPath('lib/Component/FormatBytes/templates'));
Template::addDirectory($addon->getPath('lib/Component/FormatDate/templates'));
Template::addDirectory($addon->getPath('lib/Component/FormatNumber/templates'));
Template::addDirectory($addon->getPath('lib/Component/Icon/templates'));
Template::addDirectory($addon->getPath('lib/Component/Image/templates'));
Template::addDirectory($addon->getPath('lib/Component/Input/templates'));
Template::addDirectory($addon->getPath('lib/Component/Link/templates'));
Template::addDirectory($addon->getPath('lib/Component/Listbox/templates'));
Template::addDirectory($addon->getPath('lib/Component/NumberInput/templates'));
Template::addDirectory($addon->getPath('lib/Component/Page/templates'));
Template::addDirectory($addon->getPath('lib/Component/Popover/templates'));
Template::addDirectory($addon->getPath('lib/Component/Popup/templates'));
Template::addDirectory($addon->getPath('lib/Component/ProgressBar/templates'));
Template::addDirectory($addon->getPath('lib/Component/ProgressRing/templates'));
Template::addDirectory($addon->getPath('lib/Component/QrCode/templates'));
Template::addDirectory($addon->getPath('lib/Component/Radio/templates'));
Template::addDirectory($addon->getPath('lib/Component/RadioGroup/templates'));
Template::addDirectory($addon->getPath('lib/Component/Rating/templates'));
Template::addDirectory($addon->getPath('lib/Component/RelativeTime/templates'));
Template::addDirectory($addon->getPath('lib/Component/Scroller/templates'));
Template::addDirectory($addon->getPath('lib/Component/Select/templates'));
Template::addDirectory($addon->getPath('lib/Component/Skeleton/templates'));
Template::addDirectory($addon->getPath('lib/Component/Slider/templates'));
Template::addDirectory($addon->getPath('lib/Component/Sparkline/templates'));
Template::addDirectory($addon->getPath('lib/Component/Spinner/templates'));
Template::addDirectory($addon->getPath('lib/Component/SplitPanel/templates'));
Template::addDirectory($addon->getPath('lib/Component/Switch/templates'));
Template::addDirectory($addon->getPath('lib/Component/TabGroup/templates'));
Template::addDirectory($addon->getPath('lib/Component/Tag/templates'));
Template::addDirectory($addon->getPath('lib/Component/Textarea/templates'));
Template::addDirectory($addon->getPath('lib/Component/Tooltip/templates'));
Template::addDirectory($addon->getPath('lib/Component/Tree/templates'));
Template::addDirectory($addon->getPath('lib/Component/ZoomableFrame/templates'));

if (rex::isBackend() && rex::getUser()) {
    rex_extension::register('MEDIA_FORM_EDIT', MediaExtension::extendForm(...));
    rex_extension::register('MEDIA_LIST_THUMBNAIL', MediaExtension::extendListThumbnail(...));
    rex_extension::register('MEDIA_UPDATED', MediaExtension::saveOnUpdate(...));
}

if (rex_addon::get('media_manager')->isAvailable()) {
    rex_media_manager::deleteCache();
    rex_media_manager::addEffect(rex_effect_roadie_responsive::class);
    rex_extension::register('MEDIA_MANAGER_FILTERSET', rex_effect_roadie_responsive::handle(...), rex_extension::EARLY);
}

/*
if (!rex::isBackend()) {
    rex_extension::register('ROADIE_SECTION_REPLACE_PLACEHOLDER', Section::replace(...));

    rex_extension::register('YREWRITE_SEO_TAGS', static function(rex_extension_point $ep) {
        $subject = $ep->getSubject();
        $subject[] = LowQualityImagePlaceholder::renderPreloads();
        $ep->setSubject($subject);
    });
}

if (rex::isBackend() && is_object(rex::getUser())) {
    rex_view::addCssFile($addon->getAssetsUrl('styles.css'));
    rex_view::addCssFile($addon->getAssetsUrl('roadie-notification/styles.css'));
    rex_view::addCssFile($addon->getAssetsUrl('roadie-picker/styles.css'));

    rex_extension::register('MEDIA_UPDATED', static function(rex_extension_point $ep) {
        $fileName = $ep->getParam('filename', '');
        if ('' !== $fileName) {
            $baseFileName = pathinfo($fileName, PATHINFO_FILENAME);
            foreach (['avif', 'jpg', 'webp'] as $ext) {
                rex_media_manager::deleteCache($baseFileName.'.'.$ext);
            }
        }
    });

    rex_extension::register('OUTPUT_FILTER', static function(rex_extension_point $ep) {
        $notifications = Notification::render();
        $ep->setSubject(str_replace('</body>', $notifications . '</body>', $ep->getSubject()));
    });
}



if (rex::isBackend() && rex::getUser()) {
    if ('content/edit' == rex_be_controller::getCurrentPage()) {
        rex_view::addJsFile($addon->getAssetsUrl('roadie-preview/scripts.js'));
        rex_view::addCssFile($addon->getAssetsUrl('roadie-preview/styles.css'));

        \rex_extension::register('OO_OUTPUT_FILTER', function(\rex_extension_point $ep) {
            $code = '<iframe class="roadie-preview-iframe" src="'.rex_getUrl().'"></iframe>';

            $search = ['/<div id="rex-start-of-page/im', '/<!-- END \.rex-page -->/im'];
            $replace = ['
                <div class="roadie-preview">
                    <div class="roadie-preview-main">
                        <div id="rex-start-of-page',
                '    </div>
                    <div class="roadie-preview-aside">
                        <div class="roadie-preview-container">
                            <div class="roadie-preview-container-inner">
                                <div class="roadie-preview-iframe-wrapper">
                                    '.$code.'
                                </div>
                            </div>
                            <div class="roadie-preview-toolbar">
                                <button class="btn btn-xs btn-primary" onclick="roadiePreviewRefreshIframe();">Refresh</button>
                                <ul class="roadie-preview-selector">
                                    <li><button class="btn btn-xs btn-primary">Desktop</button></li>
                                    <li data-width="1024" data-height="768"><button class="btn btn-xs btn-primary">Tablet</button></li>
                                    <li data-width="768" data-height="1024"><button class="btn btn-xs btn-primary">Tablet (Portrait)</button></li>
                                    <li data-width="375" data-height="668"><button class="btn btn-xs btn-primary">Mobil</button></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div><!-- END .rex-page -->
                '];

            $ep->setSubject(preg_replace($search, $replace, $ep->getSubject()));
        });
    }
}
*/
