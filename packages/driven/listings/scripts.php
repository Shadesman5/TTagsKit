<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Schema\Comparator;

return [

    'install' => function ($app) {

        $util = $app['db']->getUtility();
        $manager = $util->getSchemaManager();


        if ($util->tableExists('@system_node')) {

            $tableOld = $util->getTable('@system_node');
            $table = clone $tableOld;
        
            if (!$tableOld->hasColumn('listing_id')) {
                $table->addColumn('listing_id', 'integer', [
                    'unsigned' => true,
                    'length' => 10,
                    'notnull' => true,
                    'default' => 0
                ]);
            }
        
            $comparator = new Comparator();
            $manager->alterTable($comparator->diffTable($tableOld, $table));
            
        }

        if ($util->tableExists('@system_page')) {

            $tableOld = $util->getTable('@system_page');
            $table = clone $tableOld;
        
            if (!$tableOld->hasColumn('listing_id')) {
                $table->addColumn('listing_id', 'integer', [
                    'unsigned' => true,
                    'length' => 10,
                    'notnull' => true,
                    'default' => 0
                ]);
            }
        
            $comparator = new Comparator();
            $manager->alterTable($comparator->diffTable($tableOld, $table));
            
        }

        if ($util->tableExists('@listings_group_type') === false) {
            $util->createTable('@listings_group_type', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('created_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('created_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('modified_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('modified_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('description', 'string', ['length' => 255]);
                $table->addColumn('image', 'string', ['length' => 255]);
                $table->addColumn('settings', 'json_array');
                $table->addColumn('position', 'smallint');
                $table->addColumn('status', 'smallint');
                $table->addColumn('featured_from', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('featured_to', 'integer', ['notnull' => false, 'length' => 11]);
                $table->setPrimaryKey(['id']);
            });
        }

        if ($util->tableExists('@listings_listing') === false) {
            $util->createTable('@listings_listing', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('group_type_id', 'integer', ['unsigned' => true, 'length' => 10, 'notnull' => false]);
                $table->addColumn('created_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('created_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('modified_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('modified_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('description', 'string', ['length' => 255]);
                $table->addColumn('image', 'string', ['length' => 255]);
                $table->addColumn('template_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('featured_from', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('featured_to', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('position', 'smallint');
                $table->addColumn('status', 'smallint');
                $table->setPrimaryKey(['id']);
            });
        }

        if ($util->tableExists('@listings_category') === false) {
            $util->createTable('@listings_category', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('listing_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('created_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('created_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('modified_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('modified_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('description', 'string', ['length' => 255]);
                $table->addColumn('image', 'string', ['length' => 255]);
                $table->addColumn('position', 'smallint');
                $table->addColumn('status', 'smallint');
                $table->addColumn('featured_from', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('featured_to', 'integer', ['notnull' => false, 'length' => 11]);
                $table->setPrimaryKey(['id']);
            });
        }

        if ($util->tableExists('@listings_item') === false) {
            $util->createTable('@listings_item', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('category_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('listing_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('created_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('created_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('modified_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('modified_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('description', 'string', ['length' => 255]);
                $table->addColumn('volume', 'string', ['length' => 255]);
                $table->addColumn('labels', 'json_array');
                $table->addColumn('actions', 'json_array');
                $table->addColumn('image', 'string', ['length' => 255]);
                $table->addColumn('position', 'smallint');
                $table->addColumn('status', 'smallint');
                $table->addColumn('price', 'float', ['default' => 0.00]);
                $table->addColumn('tags', 'json_array');
                $table->addColumn('featured_from', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('featured_to', 'integer', ['notnull' => false, 'length' => 11]);
                $table->setPrimaryKey(['id']);
            });
        }

        if ($util->tableExists('@listings_label') === false) {
            $util->createTable('@listings_label', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('created_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('created_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('modified_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('modified_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('group_type', 'string', ['length' => 255]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('description', 'string', ['length' => 255]);
                $table->addColumn('image', 'string', ['length' => 255]);
                $table->addColumn('featured_from', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('featured_to', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('position', 'smallint');
                $table->addColumn('status', 'smallint');
                $table->setPrimaryKey(['id']);
            });
        }

        if ($util->tableExists('@listings_template') === false) {
            $util->createTable('@listings_template', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('created_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('created_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('modified_by', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
                $table->addColumn('modified_on', 'integer', ['notnull' => false, 'length' => 11]);
                $table->addColumn('title', 'string', ['length' => 255]);
                $table->addColumn('description', 'string', ['length' => 255]);
                $table->addColumn('html', 'text');
                $table->addColumn('editable', 'smallint', ['default' => 1]);
                $table->addColumn('locked', 'smallint', ['default' => 0]);
                $table->setPrimaryKey(['id']);
            });
        }

        $now = time();
        $app['db']->insert('@listings_template', [
            'id' => 1,
            'created_by' => 1,
            'created_on' => $now,
            'modified_by' => 1,
            'modified_on' => $now,
            'title' => 'Main',
            'description' => 'Menu Cards main template.',
            'html' => file_get_contents('views/admin/templates/main.php', FILE_USE_INCLUDE_PATH),
            'editable' => 1,
            'locked' => 0
        ]);

        $app['db']->insert('@listings_template', [
            'id' => 2,
            'created_by' => 1,
            'created_on' => $now,
            'modified_by' => 1,
            'modified_on' => $now,
            'title' => 'Image Showcase',
            'description' => 'Display a large image for each item with it\'s title and description.',
            'html' => file_get_contents('views/admin/templates/image-showcase.php', FILE_USE_INCLUDE_PATH),
            'editable' => 1,
            'locked' => 0
        ]);

        $group_types = [
            ['title' => 'Unsorted', 'description' => 'Default unsorted group, sort it to display on Page', 'image' => '',
                'settings' => [
                    'group' => 'unsorted',
                    'allow_nodes' => false,
                    'allow_pages' => false
                ]
            ],
            ['title' => 'Menu Cards', 'description' => 'Main menu cards group', 'image' => '',
                'settings' => [
                    'group' => 'menucards',
                    'allow_nodes' => true,
                    'allow_pages' => true,
                    'system_defaults' => [
                        'template' => 'main',
                        'max_items' => 50
                    ],
                    'user_defaults' => [
                        'show_in_menu' => true
                    ]
                ]
            ],
            ['title' => 'Mountly Cards', 'description' => 'Monthly card system group', 'image' => '',
                'settings' => [
                    'group' => 'mountlycards',
                    'allow_nodes' => false,
                    'allow_pages' => false,
                    'system_defaults' => [
                        'rotation' => 'monthly'
                    ],
                    'user_defaults' => [
                        'highlight' => false
                    ]
                ]
            ]
        ];
        foreach ($group_types as $index => $group_type) {
            $app['db']->insert('@listings_group_type', [
                'id' => $index + 1,
                'created_by' => 1,
                'created_on' => $now,
                'modified_by' => 1,
                'modified_on' => $now,
                'title' => $group_type['title'],
                'description' => $group_type['description'],
                'image' => $group_type['image'],
                'settings' => $group_type['settings'],
                'position' => 0,
                'status' => 1,
                'featured_from' => 1480575600,
                'featured_to' => 2060288885
            ]);
        }

        $listings = [
            ['group_type_id' => '1', 'title' => 'Getränke', 'description' => '', 'image' => 'storage/getraenke.jpg'],
            ['group_type_id' => '1', 'title' => 'Speisen', 'description' => '', 'image' => 'storage/kuchen.jpg']
        ];
        foreach ($listings as $index => $listing) {
            $app['db']->insert('@listings_listing', [
                'id' => $index + 1,
                'group_type_id' => 1,
                'created_by' => 1,
                'created_on' => $now,
                'modified_by' => 1,
                'modified_on' => $now,
                'title' => $listing['title'],
                'description' => $listing['description'],
                'image' => $listing['image'],
                'template_id' => 1,
                'featured_from' => 1480575600,
                'featured_to' => 2060288885,
                'position' => $index,
                'status' => 1
            ]);
        }

        $categorys = [
            ['listing_id' => '1', 'title' => 'Getränke Kategorie', 'description' => 'Beschreibung der Getränke Kategorie', 'image' => 'storage/slide2.jpg'],
            ['listing_id' => '1', 'title' => 'Getränke Kategorie 2', 'description' => 'Beschreibung der Getränke Kategorie 2', 'image' => ''],
            ['listing_id' => '2', 'title' => 'Speisen Kategorie', 'description' => 'Beschreibung der Speisenkategorie', 'image' => ''],
            ['listing_id' => '2', 'title' => 'Speisen Kategorie 2', 'description' => 'Beschreibung der Speisenkategorie 2', 'image' => '']
        ];
        foreach ($categorys as $index => $category) {
            $app['db']->insert('@listings_category', [
                'id' => $index + 1,
                'listing_id' => $category['listing_id'],
                'created_by' => 1,
                'created_on' => $now,
                'modified_by' => 1,
                'modified_on' => $now,
                'title' => $category['title'],
                'description' => $category['description'],
                'image' => $category['image'],
                'position' => $index,
                'status' => 1,
                'featured_from' => 1480575600,
                'featured_to' => 2060288885
            ]);
        }

        $items = [
            ['category_id' => '1', 'listing_id' => '1', 'title' => 'Getränk', 'description' => 'Beschreibung des Getränks', 'image' => 'storage/coffee.jpg', 'price' => '3.5'],
            ['category_id' => '1', 'listing_id' => '1', 'title' => 'Getränk 2', 'description' => 'Beschreibung des Getränks 2', 'image' => 'storage/cocktail.jpg', 'price' => '5.5'],
            ['category_id' => '1', 'listing_id' => '1', 'title' => 'Getränk 3', 'description' => 'Beschreibung des Getränks 3', 'image' => '', 'price' => '4.9'],
            ['category_id' => '2', 'listing_id' => '1', 'title' => 'Getränk 4', 'description' => 'Beschreibung des Getränks 4', 'image' => '', 'price' => '3.2'],
            ['category_id' => '2', 'listing_id' => '1', 'title' => 'Getränk 5', 'description' => 'Beschreibung des Getränks 5', 'image' => '', 'price' => '4.99'],
            ['category_id' => '2', 'listing_id' => '1', 'title' => 'Zwischen Überschrift', 'description' => 'Beschreibung des Abschnitts', 'image' => '', 'price' => ''],
            ['category_id' => '2', 'listing_id' => '1', 'title' => 'Getränk 6', 'description' => 'Beschreibung des Getränks 6', 'image' => '', 'price' => '7.99'],
            ['category_id' => '2', 'listing_id' => '1', 'title' => 'Getränk 7', 'description' => 'Beschreibung des Getränks 7', 'image' => '', 'price' => '13.0'],
            ['category_id' => '3', 'listing_id' => '2', 'title' => 'Speise', 'description' => 'Beschreibung der Speise', 'image' => 'storage/kuchen.jpg', 'price' => '7.0'],
            ['category_id' => '3', 'listing_id' => '2', 'title' => 'Speise 2', 'description' => 'Beschreibung der Speise 2', 'image' => '', 'price' => '5.0'],
            ['category_id' => '3', 'listing_id' => '2', 'title' => 'Speise 3', 'description' => 'Beschreibung der Speise 3', 'image' => '', 'price' => '5.0'],
            ['category_id' => '4', 'listing_id' => '2', 'title' => 'Speise 4', 'description' => 'Beschreibung der Speise 4', 'image' => '', 'price' => '10.0'],
            ['category_id' => '4', 'listing_id' => '2', 'title' => 'Speise 5', 'description' => 'Beschreibung der Speise 5', 'image' => '', 'price' => '4.99'],
            ['category_id' => '4', 'listing_id' => '2', 'title' => 'Zwischen Überschrift', 'description' => 'Beschreibung des Abschnitts', 'image' => '', 'price' => ''],
            ['category_id' => '4', 'listing_id' => '2', 'title' => 'Speise 6', 'description' => 'Beschreibung der Speise 6', 'image' => '', 'price' => '5.5'],
            ['category_id' => '4', 'listing_id' => '2', 'title' => 'Speise 7', 'description' => 'Beschreibung der Speise 7', 'image' => '', 'price' => '8.0']
        ];
        foreach ($items as $index => $item) {
            $app['db']->insert('@listings_item', [
                'id' => $index + 1,
                'category_id' => $item['category_id'],
                'listing_id' => $item['listing_id'],
                'created_by' => 1,
                'created_on' => $now,
                'modified_by' => 1,
                'modified_on' => $now,
                'title' => $item['title'],
                'description' => $item['description'],
                'volume' => '',
                'labels' => '{}',
                'image' => $item['image'],
                'position' => $index,
                'status' => 1,
                'actions' => '{}',
                'price' => $item['price'],
                'tags' => '{}',
                'featured_from' => 1480575600,
                'featured_to' => 2060288885
            ]);
        }

        $labels = [
            ['group_type' => 'allergen', 'title' => 'Eier/-Erzeugnisse', 'description' => 'Eier/-Erzeugnisse', 'image' => 'storage/allergens_icons/egg.svg'],
            ['group_type' => 'allergen', 'title' => 'Erdnüsse/-Erzeugnisse', 'description' => 'Alle Erdnusssorten', 'image' => 'storage/allergens_icons/nuts.svg'],
            ['group_type' => 'allergen', 'title' => 'Fisch/-Erzeugnisse', 'description' => 'Alle Fischarten ( u.a. Anchovis, Kaviar)', 'image' => 'storage/allergens_icons/fisch.svg'],
            ['group_type' => 'allergen', 'title' => 'Glutenhaltiges Getreide/-Erzeugnisse', 'description' => 'u.a. Weizen, Hartweizen, Roggen, Gerste, Hafer', 'image' => 'storage/allergens_icons/gluten.svg'],
            ['group_type' => 'allergen', 'title' => 'Krebstiere/-Erzeugnisse', 'description' => 'u.a. Krebs, Schrimps, Garnelen, Scampi, Hummer', 'image' => 'storage/allergens_icons/garnelen.svg'],
            ['group_type' => 'allergen', 'title' => 'Lupine/-Erzeugnisse', 'description' => 'u.a. Lupinenmehl, Lupinen Konzentrat, Lupinenprotein', 'image' => 'storage/allergens_icons/lupine.svg'],
            ['group_type' => 'allergen', 'title' => 'Milch/-Erzeugnisse', 'description' => 'Alle Milchprodukte', 'image' => 'storage/allergens_icons/dairy.svg'],
            ['group_type' => 'allergen', 'title' => 'Schalenfrüchte (Nüsse) /-Erzeugnisse', 'description' => 'u.a. Mandeln, Haselnüsse, Walnüsse, Pistazien, Cashewkerne', 'image' => 'storage/allergens_icons/peanut.svg'],
            ['group_type' => 'allergen', 'title' => 'Schwefeldioxid/Sulfite', 'description' => 'E220 – E228 u.a. in Trockenobst, Tomatenpüree, Wein', 'image' => 'storage/allergens_icons/sulfites.svg'],
            ['group_type' => 'allergen', 'title' => 'Sellerie/-Erzeugnisse', 'description' => 'Bleichsellerie, Knollensellerie, Staudensellerie', 'image' => 'storage/allergens_icons/celery.svg'],
            ['group_type' => 'allergen', 'title' => 'Senf/-Erzeugnisse', 'description' => 'u.a. auch Senfsprossen, Senfpulver, Senfkörner', 'image' => 'storage/allergens_icons/mustard.svg'],
            ['group_type' => 'allergen', 'title' => 'Sesam/-Erzeugnisse', 'description' => 'u.a. Sesamöl, Sesammehl, Sesamsamen', 'image' => 'storage/allergens_icons/sesam.svg'],
            ['group_type' => 'allergen', 'title' => 'Soja/-Erzeugnisse', 'description' => 'Alle Sorten Sojabohnen', 'image' => 'storage/allergens_icons/soy.svg'],
            ['group_type' => 'allergen', 'title' => 'Weichtiere/-Erzeugnisse', 'description' => 'u.a. Schnecken, Muscheln, Austern, Tintenfisch, Calamares', 'image' => 'storage/allergens_icons/shellfish.svg'],
            ['group_type' => 'additive', 'title' => 'mit Konservierungsstoff', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Farbstoff', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Antioxidationsmittel', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Süssungsmittel Saccharin', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Süssungsmittel Cyclamat', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Süssungsmittel Aspartam, enth. Phenylalaninquelle', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Süssungsmittel Acesulfam', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Phosphat', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'geschwefelt', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'chininhaltig', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'koffeinhaltig', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'mit Geschmacksverstärker', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'geschwärzt', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'gewachst', 'description' => '', 'image' => ''],
            ['group_type' => 'additive', 'title' => 'gentechnisch verändert', 'description' => '', 'image' => ''],
            ['group_type' => 'attribute', 'title' => 'Vegan', 'description' => '', 'image' => ''],
            ['group_type' => 'attribute', 'title' => 'Vegetarisch', 'description' => '', 'image' => ''],
            ['group_type' => 'attribute', 'title' => 'Pikant', 'description' => '', 'image' => ''],
            ['group_type' => 'attribute', 'title' => 'Scharf', 'description' => '', 'image' => ''],
            ['group_type' => 'attribute', 'title' => 'sehr Scharf', 'description' => '', 'image' => ''],
            ['group_type' => 'attribute', 'title' => 'mit Alkohol', 'description' => '', 'image' => '']

        ];
        foreach ($labels as $index => $label) {
            $app['db']->insert('@listings_label', [
                'id' => $index + 1,
                'created_by' => 1,
                'created_on' => $now,
                'modified_by' => 1,
                'modified_on' => $now,
                'group_type' => $label['group_type'],
                'title' => $label['title'],
                'description' => $label['description'],
                'image' => $label['image'],
                'featured_from' => 1480575600,
                'featured_to' => 2060288885,
                'position' => $index,
                'status' => 1
            ]);
        }
    },

    'uninstall' => function ($app) {

        $util = $app['db']->getUtility();

        if ($util->tableExists('@listings_listing')) {
            $util->dropTable('@listings_listing');
        }

        if ($util->tableExists('@listings_group_type')) {
            $util->dropTable('@listings_group_type');
        }

        if ($util->tableExists('@listings_category')) {
            $util->dropTable('@listings_category');
        }

        if ($util->tableExists('@listings_item')) {
            $util->dropTable('@listings_item');
        }

        if ($util->tableExists('@listings_label')) {
            $util->dropTable('@listings_label');
        }

        if ($util->tableExists('@listings_template')) {
            $util->dropTable('@listings_template');
        }
    },

    'updates' => [

        '1.0.3' => function ($app) {
            $util    = $app['db']->getUtility();
            $manager = $util->getSchemaManager();

            if ($util->tableExists('@listings_template')) {
                $tableOld = $util->listTableDetails('@listings_template');

                if ($tableOld->hasColumn('html')) {
                    $table = clone $tableOld;

                    $column = $table->getColumn('html');
                    $column->setLength(null);
                    $column->setType(Type::getType('text'));

                    $comparator = new Comparator;
                    $manager->alterTable($comparator->diffTable($tableOld, $table));

                    $app['db']->update('@listings_template', array('html' => file_get_contents('views/admin/templates/main.php', FILE_USE_INCLUDE_PATH)), array('id' => 1));
                    $app['db']->update('@listings_template', array('html' => file_get_contents('views/admin/templates/image-showcase.php', FILE_USE_INCLUDE_PATH),), array('id' => 2));
                }
            }
        }

    ]

];
