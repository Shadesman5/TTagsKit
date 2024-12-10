<?php

return [

    'name' => 'driven/listings',

    'type' => 'extension',

    'main' => 'Driven\\Listings\\Module\\ListingsModule',

    'autoload' => [
        'Driven\\Listings\\' => 'src'
    ],

    'settings' => '@listings',

    'resource' => [
        'driven/listings:' => ''
    ],

    'permissions' => [

        'listings: manage lists' => [
            'title' => 'Manage lists',
            'description' => 'Create, edit, delete and publish lists'
        ],
        'listings: manage labels' => [
            'title' => 'Manage Labels',
            'description' => 'Create, edit and delete labels'
        ],
        'listings: manage templates' => [
            'title' => 'Manage Templates',
            'description' => 'Create, edit and delete templates'
        ]

    ],

    'config' => [
        'defaults' => [
            'listingTitle' => 'uk-h1',
            'listingDescription' => '',

            'categoryTitleDescription' => 'uk-margin-small-bottom uk-margin-small-top',
            'categoryTitle' => 'uk-h2 uk-text-center uk-text-uppercase uk-margin-remove',
            'categoryDescription' => 'uk-text-large uk-text-center',
            'categoryImage' => 'uk-thumbnail uk-border-rounded',

            'itemContainer' => 'uk-margin-small-bottom uk-padding-small-bottom itemContainer',
            'itemTitleDescription' => 'uk-flex-item-auto uk-margin-small-right',
            'itemTitle' => 'uk-h4',
            'itemDescription' => '',
            'itemTagsContainer' => 'uk-margin-small-top uk-text-bold uk-text-primary',
            'itemTag' => 'uk-badge',
            'itemLabelsContainer' => 'labels uk-margin-small-top uk-width',
            'itemLabelImage' => '',

            'itemModalLabel' => 'uk-width uk-thumbnail modalLabel',

            'itemPriceVolume' => 'uk-text-right uk-flex-item-none uk-text-medium uk-text-primary',
            'itemPrice' => 'uk-width-auto uk-margin-small-right',
            'itemVolume' => 'uk-width-auto uk-margin-small-right',

            'itemImage' => 'uk-flex-item-none uk-overflow-hidden uk-border-rounded'
        ]
    ],

    'routes' => [

        '/listings' => [
            'name' => '@listings',
            'controller' => 'Driven\\Listings\\Controller\\ListingsController'
        ],
        '/listings/group_types' => [
            'name' => '@listings/group_types',
            'controller' => 'Driven\\Listings\\Controller\\GroupTypesController'
        ],
        '/listings/category' => [
            'name' => '@listings/category',
            'controller' => 'Driven\\Listings\\Controller\\CategoryController'
        ],
        '/listings/category/item' => [
            'name' => '@listings/category/item',
            'controller' => 'Driven\\Listings\\Controller\\ItemController'
        ],
        '/listings/labels' => [
            'name' => '@listings/labels',
            'controller' => 'Driven\\Listings\\Controller\\LabelsController'
        ],
        '/listings/templates' => [
            'name' => '@listings/templates',
            'controller' => 'Driven\\Listings\\Controller\\TemplatesController'
        ],
        '/listings/info' => [
            'name' => '@listings/info',
            'controller' => 'Driven\\Listings\\Controller\\InfoController'
        ]

    ],

    'menu' => [

        'listings' => [
            'label' => 'Menu Cards',
            'icon' => 'driven/listings:icon.svg',
            'url' => '@listings',
            'active' => '@listings*',
            'access' => 'listings: manage lists'
        ],

        'listings: root' => [
            'parent' => 'listings',
            'label' => 'Cards',
            'url' => '@listings'
        ],

        'listings: labels' => [
            'access' => 'listings: manage labels',
            'parent' => 'listings',
            'label' => 'Labels',
            'url' => '@listings/labels'
        ],

        'listings: templates' => [
            'access' => 'listings: manage templates',
            'parent' => 'listings',
            'label' => 'Templates',
            'url' => '@listings/templates'
        ],

        'listings: info' => [
            'access' => 'listings: manage templates',
            'parent' => 'listings',
            'label' => 'Info',
            'url' => '@listings/info'
        ]
    ],

    'widgets' => [
        'widgets/ListingsWidget.php'
    ]
];
