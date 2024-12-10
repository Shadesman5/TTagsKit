<?php

return [

    'name' => 'system/finder',

    'autoload' => [

        'Pagekit\\Finder\\' => 'src'

    ],

    'main' => function ($app) {
        $this->config['storage'] = '/' . trim(($this->config['storage'] ?: 'storage'), '/');
        $app['path.storage'] = $app['path'] . $this->config['storage'];
        $app['locator']->add('storage:', $app['path.storage']);

        // Define the user storage path
        $this->config['userstorage'] = '/' . trim(($this->config['userstorage'] ?: 'userstorage'), '/');
        $app['path.userstorage'] = $app['path'] . $this->config['userstorage'];
        $app['locator']->add('userstorage:', $app['path.userstorage']);
    },

    'routes' => [

        '/system/finder' => [
            'name' => '@system/finder',
            'controller' => 'Pagekit\\Finder\\Controller\\FinderController'
        ],
        '/site/storage' => [
            'name' => '@site/storage',
            'controller' => 'Pagekit\\Finder\\Controller\\StorageController'
        ],
        '/user/userstorage' => [
            'name' => '@user/userstorage',
            'controller' => 'Pagekit\\Finder\\Controller\\UserStorageController'
        ]

    ],

    'resources' => [

        'system/finder:' => ''

    ],

    'events' => [

        'view.scripts' => function ($event, $scripts) {
            $scripts->register('panel-finder', 'system/finder:app/bundle/panel-finder.js', ['vue', 'uikit-upload']);
            $scripts->register('input-image', 'system/finder:app/bundle/input-image.js', ['vue', 'panel-finder']);
            $scripts->register('input-video', 'system/finder:app/bundle/input-video.js', ['vue', 'panel-finder']);
            $scripts->register('link-storage', 'system/finder:app/bundle/link-storage.js', ['~panel-link']);
        },

        'view.system:modules/settings/views/settings' => function ($event, $view) use ($app) {
            $view->data('$settings', [
                'config' => [
                    $this->name => ['storage' => $this->config['storage'] === '/storage' ? '' : $this->config['storage']],
                    $this->name => ['userstorage' => $this->config['userstorage'] === '/userstorage' ? '' : $this->config['userstorage']]
                ],
                'options' => [
                    $this->name => ['extensions' => $this->config['extensions']]
                ]
            ]);
        },

        'system.finder' => function ($event) use ($app) {
            if ($app['user']->hasAccess('system: manage storage | system: manage storage read only')) {
                $event->path(
                    '#^' . preg_quote(strtr($app['path.storage'], '\\', '/'), '#') . '($|\/.*)#',
                    $app['user']->hasAccess('system: manage storage') ? 'w' : ($app['user']->hasAccess('system: manage storage read only') ? 'r' : false)
                );
            }

            if ($app['user']->hasAccess('system: manage all userstorages')) {
                $pathPattern = '#^' . preg_quote(strtr($app['path.userstorage'], '\\', '/'), '#') . '.*$#';
                $event->path($pathPattern, 'w');
            } else {
                // Standardzugriff für normale Benutzer auf ihr eigenes Verzeichnis
                $userId = $app['user']->id;
                $userStoragePath = $app['path.userstorage'] . '/' . $userId;
                $pathPattern = '#^' . preg_quote(strtr($userStoragePath, '\\', '/'), '#') . '($|\/.*)#';
                $event->path(
                    $pathPattern,
                    $app['user']->hasAccess('system: manage userstorage') ? 'w' : ($app['user']->hasAccess('system: manage userstorage read only') ? 'r' : false)
                );
            }
        }

    ],

    'permissions' => [

        'system: manage storage' => [
            'title' => 'Manage Storage',
            'trusted' => true
        ],
        'system: manage storage read only' => [
            'title' => 'Manage Storage (Read only)'
        ],
        'system: manage all userstorages' => [
            'title' => 'Manage all User Storages',
            'trusted' => true
        ],
        'system: manage userstorage' => [
            'title' => 'Manage User Storage',
            'trusted' => true
        ],
        'system: manage userstorage read only' => [
            'title' => 'Manage User Storage (Read only)'
        ]

    ],

    'menu' => [

        'site' => [
            'label' => 'Storage',
            'icon' => 'system/site:assets/images/icon-site.svg',
            'url' => '@site/storage',
            'access' => 'system: manage storage',
            'active' => '@site(/*)?',
            'priority' => 105
        ],
        'system: storage' => [
            'label' => 'Storage',
            'parent' => 'site',
            'url' => '@site/storage',
            'access' => 'system: manage storage | system: manage storage read only',
            'priority' => 20
        ]

    ],

    'config' => [

        'storage' => false,

        'userstorage' => false,

        'extensions' => 'bmp,gif,jpeg,jpg,mp4,ogg,pdf,png,svgz,svg,swf'

    ]

];
