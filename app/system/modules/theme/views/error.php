<!DOCTYPE html>
<html>

<head>
    <title><?= __('Error') ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <link href="<?= $view->url()->getStatic('system/theme:favicon.ico') ?>" rel="shortcut icon" type="image/x-icon">
    <link href="<?= $view->url()->getStatic('system/theme:apple_touch_icon.png') ?>" rel="apple-touch-icon-precomposed">
    <link href="<?= $view->url()->getStatic('system/theme:css/theme.css') ?>" rel="stylesheet">
</head>

<body>

    <div class="uk-height-viewport uk-flex uk-flex-center uk-flex-middle uk-text-center">
        <div class="tm-container">

            <a title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" href="https://ttags.de" target="_blank">
                <img title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" class="uk-margin-large-bottom" src="<?= $view->url()->getStatic('app/system/assets/images/ttags-logo.png') ?>" width="125" alt="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte">
            </a>

            <div class="uk-panel uk-panel-box">
                <h1 class="uk-h2"><?= $title ?></h1>
            </div>

        </div>
    </div>

</body>

</html>