<?php foreach ($widgets as $widget) : ?>
<div class="uk-width-1-<?= count($widgets) ?>">

    <div class="uk-panel <?= $widget->theme['panel'] ?> <?= $widget->theme['alignment'] ? 'uk-text-center' : '' ?> <?= $widget->theme['html_class'] ?>">

        <?php if (!$widget->theme['title_hide']) : ?>
        <h3 class="<?= $widget->theme['title_size'] ?>"><?= $widget->title ?></h3>
        <?php endif ?>

        <?= $widget->get('result') ?>

    </div>

</div>
<?php endforeach ?>
