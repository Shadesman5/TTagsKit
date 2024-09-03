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
        'listings: manage allergens' => [
            'title' => 'Manage Allergens',
            'description' => 'Create, edit and delete allergens'
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

            'categoryTitleDescription'=>'uk-margin-small-bottom uk-margin-small-top',
            'categoryTitle' => 'uk-h2 uk-text-center uk-text-uppercase uk-margin-remove',
            'categoryDescription' => 'uk-text-large uk-text-center',
            'categoryImage' => 'uk-thumbnail',

            'itemContainer'=>'',
            'itemTitleDescription' => 'uk-width-expand uk-flex-item-1',
            'itemTitle' => 'uk-h5',
            'itemDescription' => '',

            'itemVolume' => 'uk-width-auto uk-text-right',
            'itemPrice' => 'uk-width-auto uk-text-right uk-text-medium',
            'itemImage' => 'uk-width-auto',
            'itemTagsContainer' => 'uk-margin-top uk-text-bold uk-text-primary',
            'itemTag' => 'uk-badge',
            'itemAllergensContainer' => 'allergens uk-margin-small-top uk-text-primary',
            'itemAllergen' => ''


        ]
    ],

    'routes' => [

        '/listings' => [
            'name' => '@listings',
            'controller' => 'Driven\\Listings\\Controller\\ListingsController'
        ],
        '/listings/category' => [
            'name' => '@listings/category',
            'controller' => 'Driven\\Listings\\Controller\\CategoryController'
        ],
        '/listings/category/item' => [
            'name' => '@listings/category/item',
            'controller' => 'Driven\\Listings\\Controller\\ItemController'
        ],
        '/listings/allergens' => [
            'name' => '@listings/allergens',
            'controller' => 'Driven\\Listings\\Controller\\AllergensController'
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
            'access' => 'listings: manage lists',
            'label' => 'Menu Cards',
            'icon' => 'driven/listings:icon.svg',
            'url' => '@listings',
            'active' => '@listings*'

        ],

        'listings: root' => [
            'parent' => 'listings',
            'label' => 'Cards',
            'url' => '@listings'
        ],

        'listings: allergens' => [
            'access' => 'listings: manage allergens',
            'parent' => 'listings',
            'label' => 'Allergens',
            'url' => '@listings/allergens'
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
    ]
];
