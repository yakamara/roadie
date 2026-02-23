<?php

use Yakamara\Roadie\Component\Component;
use Yakamara\Roadie\Component\Page\Page;
use Yakamara\Roadie\Component\Page\PageNavigationPlacement;

/** @var Page $this */
?>

<wa-page <?= $this->attributes->with([
    'mobile-breakpoint' => $this->mobileBreakpoint,
    'navigation-placement' => $this->navigationPlacement !== PageNavigationPlacement::Start ? $this->navigationPlacement : null,
    'nav-open' => $this->navOpen,
    'disable-navigation-toggle' => $this->disableNavigationToggle,
    'with-banner' => $this->banner !== null,
    'with-header' => $this->header !== null,
    'with-subheader' => $this->subheader !== null,
    'with-navigation' => $this->navigation !== null,
    'with-aside' => $this->aside !== null,
    'with-footer' => $this->footer !== null,
])->toString() ?>>
    <?= Component::slot($this->banner, 'banner') ?>
    <?= Component::slot($this->header, 'header') ?>
    <?= Component::slot($this->subheader, 'subheader') ?>
    <?= Component::slot($this->navigation, 'navigation') ?>
    <?= Component::slot($this->navigationHeader, 'navigation-header') ?>
    <?= Component::slot($this->navigationFooter, 'navigation-footer') ?>
    <?= Component::slot($this->navigationToggle, 'navigation-toggle') ?>
    <?= Component::slot($this->navigationToggleIcon, 'navigation-toggle-icon') ?>
    <?= Component::slot($this->mainHeader, 'main-header') ?>
    <?= Component::slot($this->mainFooter, 'main-footer') ?>
    <?= Component::slot($this->aside, 'aside') ?>
    <?= Component::slot($this->footer, 'footer') ?>
    <?= Component::slot($this->skipToContent, 'skip-to-content') ?>
    <?= Component::slot($this->content) ?>
</wa-page>
