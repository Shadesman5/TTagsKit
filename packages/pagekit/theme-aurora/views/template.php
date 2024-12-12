<!DOCTYPE html>
<html class="<?= $params['html_class'] ?>" lang="<?= $intl->getLocaleTag() ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= $view->render('head') ?>
    <?php $view->style('theme', $params['style'] ? 'theme:css/theme.' . $params['style'] . '.css' : 'theme:css/theme.css') ?>
    <?php $view->script('verticalDropdown', 'theme:js/verticalDropdown.js', ['jquery']) ?>
    <?php $view->script('theme', 'theme:js/theme.js', ['uikit-sticky',  'uikit-lightbox',  'uikit-parallax', 'uikit-slideshow', 'verticalDropdown']) ?>
</head>

<body <?= $params['classes.body'] ?>>

    <div class="uk-grid tm-wrapper" uk-height-match>

        <div class="uk-width-1-1 tm-sidebar-wrapper uk-hidden-medium uk-hidden-small">

            <?php if ($params['logo'] || $view->menu()->exists('main') || $view->position()->exists('sidebar_menu')) : ?>
                <div class="tm-sidebar-menu-container" data-uk-sticky>

                    <div class="uk-width uk-margin-small gtranslate_wrapper"></div>

                    <a class="tm-sidebar-logo" title="<?= $this->escape($params['title']) ?>" href="<?= $view->url()->get() ?>">
                        <?php if ($params['logo']) : ?>
                            <img class="tm-logo uk-responsive-height" title="<?= $this->escape($params['title']) ?>" src="<?= $this->escape($params['logo']) ?>" alt="<?= $this->escape($params['title']) ?>">
                        <?php else : ?>
                            <?= $params['title'] ?>
                        <?php endif ?>
                    </a>

                    <?php if ($view->menu()->exists('main') || $view->position()->exists('sidebar_menu')) : ?>
                        <div class="tm-sidebar-nav">
                            <?= $view->menu('main', 'menu-navbar.php') ?>
                            <?= $view->position('sidebar_menu', 'position-blank.php') ?>
                        </div>
                    <?php endif ?>

                </div>
            <?php endif ?>

            <?php if ($view->position()->exists('sidebar_main') || $view->position()->exists('sidebar_social')) : ?>
                <div class="tm-sidebar-widget-container">

                    <?php if ($view->position()->exists('sidebar_main')) : ?>
                        <div class="tm-sidebar-main">
                            <?= $view->position('sidebar_main', 'position-grid.php') ?>
                        </div>
                    <?php endif ?>

                    <?php if ($view->position()->exists('sidebar_social')) : ?>
                        <div class="tm-sidebar-social uk-flex uk-flex-middle uk-flex-center">
                            <?= $view->position('sidebar_social', 'position-blank.php') ?>
                        </div>
                    <?php endif ?>

                </div>
            <?php endif ?>

        </div>

        <div class="uk-width-1-1 tm-content-wrapper <?= ($params['totop_scroller'] || $view->menu()->exists('footer')) ? '' : '' ?>">

            <?php if ($view->position()->exists('toolbar')) : ?>
                <div class="tm-toolbar uk-flex uk-flex-middle uk-flex-space-between uk-visible-large">
                    <?= $view->position('toolbar', 'position-blank.php') ?>
                </div>
            <?php endif ?>

            <?php if ($params['logo_small'] || $view->position()->exists('offcanvas') || $view->menu()->exists('offcanvas')) : ?>
                <nav class="tm-navbar uk-navbar uk-hidden-large" <?= $params['classes.sticky'] ?>>

                    <div class="uk-flex uk-flex-space-between uk-flex-middle">
                        <?php if ($view->position()->exists('offcanvas') || $view->menu()->exists('offcanvas')) : ?>
                            <div class="uk-width">
                                <a title="Mobile Navigation" href="#offcanvas" class="uk-navbar-toggle" data-uk-offcanvas></a>
                            </div>
                        <?php endif ?>

                        <div class="uk-width">
                            <a class="uk-navbar-brand" title="<?= $this->escape($params['title']) ?>" href="<?= $view->url()->get() ?>">
                                <?php if ($params['logo_small']) : ?>
                                    <img class="tm-logo-small uk-responsive-height" title="<?= $this->escape($params['title']) ?>" src="<?= $this->escape($params['logo_small']) ?>" alt="<?= $this->escape($params['title']) ?>">
                                <?php else : ?>
                                    <?= $params['title'] ?>
                                <?php endif ?>
                            </a>
                        </div>

                        <div class="uk-width uk-text-right uk-hidden-large gtranslate_wrapper"></div>
                    </div>

                </nav>
            <?php endif ?>

            <?php if ($view->position()->exists('hero')) : ?>
                <div id="tm-hero" class="tm-hero uk-section uk-section-large uk-background-cover uk-flex uk-flex-middle <?= $params['classes.hero'] ?>" <?= $params['hero_image'] ? "style=\"background-image: url('{$view->url($params['hero_image'])}');\"" : '' ?> <?= $params['classes.parallax'] ?>>
                    <div class="uk-container uk-container-center">

                        <section class="uk-grid uk-grid-match" uk-grid>
                            <?= $view->position('hero', 'position-grid.php') ?>
                        </section>

                    </div>
                </div>
            <?php endif ?>

            <?php if ($view->position()->exists('content_top')) : ?>
                <div id="content-top" class="tm-block-content-top<?= ($params['content_top_padding']) ? ' tm-content-top-padding-false' : '' ?>">

                    <section class="uk-grid uk-grid-match" uk-grid>
                        <?= $view->position('content_top', 'position-grid.php') ?>
                    </section>

                </div>
            <?php endif; ?>

            <div class="tm-content-container uk-grid uk-grid-small" uk-grid data-uk-grid-margin>

                <?php if ($view->position()->exists('top')) : ?>
                    <div id="tm-top" class="tm-top uk-width-1-1">

                        <section class="uk-grid uk-grid-match" uk-grid>
                            <?= $view->position('top', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php if ($view->position()->exists('top_b')) : ?>
                    <div id="tm-top-b" class="tm-top-b uk-width-1-1">

                        <section class="uk-grid uk-grid-match" uk-grid>
                            <?= $view->position('top_b', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php if ($view->position()->exists('top_c')) : ?>
                    <div id="tm-top-c" class="tm-top-c uk-width-1-1">

                        <section class="uk-grid uk-grid-match" uk-grid>
                            <?= $view->position('top_c', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php if ($view->position()->exists('top_d')) : ?>
                    <div id="tm-top-d" class="tm-top-d uk-width-1-1">

                        <section class="uk-grid uk-grid-match" uk-grid>
                            <?= $view->position('top_d', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php
                // Render den Content und überprüfe, ob das Artikel-Tag leer ist
                $content = $view->render('content');
                $isEmptyContent = preg_match('/<article[^>]*>\s*(?:&nbsp;|<!--[^>]*-->|\s)*<\/article>/', $content);
                ?>

                <div id="tm-main" class="tm-main uk-width-1-1 <?= $isEmptyContent ? 'uk-margin-remove' : ''; ?>">

                    <div class="uk-grid" uk-grid>

                        <main class="<?= $view->position()->exists('sidebar') ? 'uk-width-3-4@m' : 'uk-width-1-1'; ?>">
                            <?= $content ?>
                        </main>

                        <?php if ($view->position()->exists('sidebar')) : ?>
                            <aside class="uk-width-1-4@m <?= $params['sidebar_first'] ? 'uk-flex-order-first-medium' : ''; ?>">
                                <?= $view->position('sidebar', 'position-panel.php') ?>
                            </aside>
                        <?php endif ?>

                    </div>

                </div>

                <?php if ($view->position()->exists('bottom')) : ?>
                    <div id="tm-bottom" class="tm-bottom uk-width-1-1">

                        <section class="uk-grid uk-grid-small uk-grid-match" uk-grid>
                            <?= $view->position('bottom', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php if ($view->position()->exists('bottom_b')) : ?>
                    <div id="tm-bottom-b" class="tm-bottom-b uk-width-1-1">

                        <section class="uk-grid uk-grid-small uk-grid-match" uk-grid>
                            <?= $view->position('bottom_b', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php if ($view->position()->exists('bottom_c')) : ?>
                    <div id="tm-bottom-c" class="tm-bottom-c uk-width-1-1">

                        <section class="uk-grid uk-grid-small uk-grid-match" uk-grid>
                            <?= $view->position('bottom_c', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

                <?php if ($view->position()->exists('bottom_d')) : ?>
                    <div id="tm-bottom-d" class="tm-bottom-d uk-width-1-1">

                        <section class="uk-grid uk-grid-small uk-grid-match" uk-grid>
                            <?= $view->position('bottom_d', 'position-grid.php') ?>
                        </section>

                    </div>
                <?php endif ?>

            </div>

            <?php if ($view->position()->exists('content_bottom')) : ?>
                <div id="content-bottom" class="tm-block-content-bottom<?= ($params['content_bottom_padding']) ? ' tm-content-bottom-padding-false' : '' ?>">

                    <section class="uk-grid uk-grid-match" uk-grid>
                        <?= $view->position('content_bottom', 'position-grid.php') ?>
                    </section>

                </div>
            <?php endif; ?>

            <?php if ($view->position()->exists('footer')) : ?>
                <div class="tm-block-footer uk-text-center uk-text-muted">

                    <section class="uk-grid uk-grid-match" uk-grid>
                        <?= $view->position('footer', 'position-grid.php') ?>
                    </section>

                </div>
            <?php endif ?>

            <div id="tm-footer" class="tm-footer fotterIcons uk-text-center">
                <section class="uk-grid" uk-grid>
                    <div class="uk-width-1-1">
                        <p class="uk-panel-title uk-h3">Powered by <a title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" href="https://www.ttags.de" target="_blank">TTAGS</a></p>

                        <ul class="uk-grid uk-grid-medium uk-flex uk-flex-center uk-margin-medium-bottom">
                            <li>
                                <a title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" href="https://www.ttags.de" target="_blank">
                                    <img title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" src="storage/ttags-icon.svg" alt="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte">
                                </a>
                            </li>
                            <li>
                                <a title="Besuchen Sie TTags auf Facebook" href="https://www.facebook.com/TTagsde-111228028042430" target="_blank" class="uk-icon-medium uk-icon-facebook"></a>
                            </li>
                            <li>
                                <a title="Besuchen Sie TTags auf Instagram" href="https://www.instagram.com/ttags.de/" target="_blank" class="uk-icon-medium uk-icon-instagram"></a>
                            </li>
                        </ul>
                        <hr>
                        <div class="uk-position-relative">
                            <p>
                                <a title="TTags - Impressum" href="https://ttags.de/impressum" target="_blank">Impressum</a> |
                                <a title="TTags - Datenschutz" href="https://ttags.de/datenschutz" target="_blank">Datenschutz</a>
                            </p>

                        </div>
                    </div>
                </section>

                <?php if ($params['totop_scroller']) : ?>
                    <a title="nach oben Scrollen" id="tm-anchor-bottom" class="tm-totop-scroller" data-uk-smooth-scroll href="#"></a>
                <?php endif ?>

                <?php if ($view->menu()->exists('footer')) : ?>
                    <?= $view->menu('footer', 'menu-footer.php') ?>
                <?php endif ?>
            </div>

        </div>

    </div>

    <?php if ($view->position()->exists('offcanvas') || $view->menu()->exists('offcanvas')) : ?>
        <div id="offcanvas" class="uk-offcanvas">
            <div class="uk-offcanvas-bar">

                <?php if ($params['logo_offcanvas']) : ?>
                    <div class="uk-panel uk-text-center">
                        <a title="<?= $this->escape($params['title']) ?>" href="<?= $view->url()->get() ?>">
                            <img title="<?= $this->escape($params['title']) ?>" src="<?= $this->escape($params['logo_offcanvas']) ?>" alt="<?= $this->escape($params['title']) ?>">
                        </a>
                    </div>
                <?php endif ?>

                <?php if ($view->menu()->exists('offcanvas')) : ?>
                    <?= $view->menu('offcanvas', ['class' => 'uk-nav-offcanvas']) ?>
                <?php endif ?>

                <?php if ($view->position()->exists('offcanvas')) : ?>
                    <?= $view->position('offcanvas', 'position-panel.php') ?>
                <?php endif ?>

            </div>
        </div>
    <?php endif ?>

    <?= $view->render('footer') ?>

</body>

</html>