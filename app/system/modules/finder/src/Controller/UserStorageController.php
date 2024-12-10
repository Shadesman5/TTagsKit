<?php

namespace Pagekit\Finder\Controller;

use Pagekit\Application as App;
use Pagekit\User\Model\User;

/**
 * @Access("system: manage all userstorages | system: manage userstorage | system: manage userstorage read only", admin=true)
 */
class UserStorageController
{
    public function indexAction()
    {
        $users = [];

        if (App::user()->hasAccess('system: manage all userstorages')) {
            $users = User::findAll();
            $mode = 'w';
        } else {

            $users = [App::user()];

            if (App::user()->hasAccess('system: manage userstorage')) {
                $mode = 'w';
            } elseif (App::user()->hasAccess('system: manage userstorage read only')) {
                $mode = 'r';
            } else {
                App::abort(403, __('Insufficient User Permissions.'));
            }
        }

        return [
            '$view' => [
                'title' => __('User Storage'),
                'name'  => 'system:modules/finder/views/userstorage.php'
            ],
            'users' => array_map(function ($user) use ($mode) {
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'mode' => $mode
                ];
            }, $users),
            'root' => App::module('system/finder')->config('userstorage'),
            'mode' => $mode
        ];
    }
}
