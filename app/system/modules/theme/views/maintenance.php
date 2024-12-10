<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= $view->render('head') ?>
        <?php $view->style('theme', 'system/theme:css/theme.css') ?>
    </head>
    <body>

        <div class="uk-height-viewport uk-flex uk-flex-center uk-flex-middle uk-text-center">
            <div class="tm-container">

                <a title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" href="https://ttags.de" target="_blank">
                    <img title="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte" class="uk-margin-large-bottom" width="125px" src="<?= $view->url()->getStatic($logo) ?>" alt="TTags - Simple, Smart, Innovative | Mehr als nur eine Speisekarte">
                </a>

                <div class="uk-panel uk-panel-box">
                    <h1><?= __('Maintenance') ?></h1>
                    <p><?= $message ?></p>
                </div>

            </div>
        </div>

    </body>
</html>
