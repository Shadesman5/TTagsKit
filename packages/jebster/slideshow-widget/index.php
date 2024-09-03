<?php

use Pagekit\Application;



return [
    'name' => 'slideshow-widget',

    'main' => function(Application $app) {

    },

    'autoload' => [
        'Jebster\\Slideshow\\' => 'src'
    ],

    'resources' => [
        'slideshow-widget:' => ''
    ],

    'routes' => [
        '/slideshow' => [
            'name' => '@slideshow-widget',
            'controller' => 'Jebster\\Slideshow\\Controller\\SlideshowController'
        ]
    ],

    'widgets' => [
        'widgets/slideshow.php'
    ],
];