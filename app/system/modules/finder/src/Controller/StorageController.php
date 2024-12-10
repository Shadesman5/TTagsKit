<?php

namespace Pagekit\Finder\Controller;

use Pagekit\Application as App;

/**
 * @Access("system: manage storage | system: manage storage read only", admin=true)
 */
class StorageController
{
    public function indexAction()
    {
        if (App::user()->hasAccess('system: manage storage')) {
            $mode = 'w';
        } elseif (App::user()->hasAccess('system: manage storage read only')) {
            $mode = 'r';
        } else {
            App::abort(403, __('Insufficient User Permissions.'));
        }

        return [
            '$view' => [
                'title' => __('Storage'),
                'name'  => 'system:modules/finder/views/storage.php'
            ],
            'root' => App::module('system/finder')->config('storage'),
            'mode' => $mode
        ];
    }
}
