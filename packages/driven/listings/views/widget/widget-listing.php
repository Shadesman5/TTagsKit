<div class="uk-grid uk-grid-small" data-uk-grid-margin>
    <?php if (!empty($listings)): ?>
        <?php if (count($listings) === 1): ?>
            <!-- Ein Listing, volle Breite -->
            <div class="uk-width-1-1">
                <a class="uk-thumbnail uk-border-remove" href="<?= $listings[1]->path ?>">
                    <span class="img-box img-height">
                        <img src="<?= '/' . ltrim($listings[1]->image, '/') ?>" alt="<?= $listings[1]->title ?>" object-fit="cover">
                    </span>
                    <div class="uk-thumbnail-caption"><?= $listings[1]->title ?></div>
                </a>
            </div>
        <?php elseif (count($listings) === 2): ?>
            <!-- Zwei Listings, jeweils halbe Breite -->
            <?php foreach ($listings as $listing): ?>
                <div class="uk-width-1-2">
                    <a class="uk-thumbnail uk-border-remove" href="<?= $listing->path ?>">
                        <span class="img-box">
                            <img src="<?= '/' . ltrim($listing->image, '/') ?>" alt="<?= $listing->title ?>" object-fit="cover">
                        </span>
                        <div class="uk-thumbnail-caption"><?= $listing->title ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php elseif (count($listings) > 2): ?>
            <!-- Mehr als zwei Listings -->
            <div class="uk-width-1-2">
                <a class="uk-thumbnail uk-border-remove" href="<?= $listings[1]->path ?>">
                    <span class="img-box">
                        <img src="<?= '/' . ltrim($listings[1]->image, '/') ?>" alt="<?= $listings[1]->title ?>" object-fit="cover">
                    </span>
                    <div class="uk-thumbnail-caption"><?= $listings[1]->title ?></div>
                </a>
            </div>
            <div class="uk-width-1-2">
                <a class="uk-thumbnail uk-border-remove" href="<?= $listings[2]->path ?>">
                    <span class="img-box">
                        <img src="<?= '/' . ltrim($listings[2]->image, '/') ?>" alt="<?= $listings[2]->title ?>" object-fit="cover">
                    </span>
                    <div class="uk-thumbnail-caption"><?= $listings[2]->title ?></div>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($groupType) && count($listings) > 2): ?>
        <!-- Gruppe wird nur angezeigt, wenn mehr als zwei Listings -->
        <div class="uk-width-1-1">
            <a class="uk-thumbnail uk-border-remove" href="<?= $groupType->path ?>">
                <span class="img-box img-height">
                    <img src="<?= '/' . ltrim($groupType->image, '/') ?>" alt="<?= $groupType->title ?>" object-fit="cover">
                </span>
                <div class="uk-thumbnail-caption"><?= $groupType->title ?></div>
            </a>
        </div>
    <?php endif; ?>
</div>