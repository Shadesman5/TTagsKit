<?php

namespace Pagekit\User\Controller;

use Pagekit\Application as App;
use Pagekit\User\Model\Role;
use Pagekit\User\Model\User;

/**
 * @Access(admin=true)
 */
class UserController
{
    /**
     * @Access("system: access admin area")
     * @Request({"filter": "array", "page":"int"})
     */
    public function indexAction($filter = [], $page = null)
    {
        $currentUser = App::user();
        $canManageUsers = $currentUser->hasAccess('user: manage users');

        $roles = $this->getRoles();
        unset($roles[Role::ROLE_AUTHENTICATED]);

        return [
            '$view' => [
                'title' => __('Users'),
                'name' => 'system/user/admin/user-index.php'
            ],
            '$data' => [
                'config' => [
                    'statuses' => User::getStatuses(),
                    'roles' => array_values($roles),
                    'emailVerification' => App::module('system/user')->config('require_verification'),
                    'filter' => (object) $filter,
                    'page' => $page,
                    'canManageUsers' => $canManageUsers
                ]
            ]
        ];
    }

    /**
     * @Request({"id": "int"})
     */
    public function editAction($id = 0)
    {
        $currentUser = App::user();

        if ($id === 0) {

            if (!$currentUser->hasAccess('user: manage users')) {
                App::abort(403, __('Insufficient User Permissions.'));
            }

            $user = User::create(['roles' => [Role::ROLE_AUTHENTICATED]]);
        } else {

            $user = User::find($id);

            if (!$user) {
                App::abort(404, 'User not found.');
            }

            if ($currentUser->id !== $user->id && !$currentUser->hasAccess('user: manage users')) {
                App::abort(403, __('Insufficient User Permissions.'));
            }
        }

        $canManageUsers = $currentUser->hasAccess('user: manage users');

        return [
            '$view' => [
                'title' => $id ? __('Edit User') : __('Add User'),
                'name' => 'system/user/admin/user-edit.php'
            ],
            '$data' => [
                'user' => $user,
                'config' => [
                    'statuses' => User::getStatuses(),
                    'roles' => array_values($this->getRoles($user)),
                    'emailVerification' => App::module('system/user')->config('require_verification'),
                    'currentUser' => App::user()->id,
                    'canManageUsers' => $canManageUsers
                ]
            ]
        ];
    }

    /**
     * @Access("user: manage user permissions")
     */
    public function permissionsAction()
    {
        return [
            '$view' => [
                'title' => __('Permissions'),
                'name' => 'system/user/admin/permission-index.php'
            ],
            '$data' => [
                'permissions' => App::module('system/user')->getPermissions(),
                'roles' => array_values(Role::query()->orderBy('priority')->get())
            ]
        ];
    }

    /**
     * @Access("user: manage user permissions")
     * @Request({"id": "int"})
     */
    public function rolesAction($id = null)
    {
        return [
            '$view' => [
                'title' => __('Roles'),
                'name' => 'system/user/admin/role-index.php'
            ],
            '$config' => [
                'role' => $id
            ],
            '$data' => [
                'permissions' => App::module('system/user')->getPermissions(),
                'roles' => array_values(Role::query()->orderBy('priority')->get())
            ]
        ];
    }

    /**
     * @Access("system: access settings")
     */
    public function settingsAction()
    {
        return [
            '$view' => [
                'title' => __('User Settings'),
                'name' => 'system/user/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module('system/user')->config()
            ]
        ];
    }

    /**
     * Gets the user roles.
     *
     * @param  User $user
     * @return array
     */
    protected function getRoles(User $user = null)
    {
        $roles = [];
        $self  = $user && $user->id === App::user()->id;
        foreach (Role::where(['id <> ?'], [Role::ROLE_ANONYMOUS])->orderBy('priority')->get() as $role) {

            $r = $role->jsonSerialize();

            if ($role->isAuthenticated()) {
                $r['disabled'] = true;
            }

            if ($user && $role->isAdministrator() && (!App::user()->isAdministrator() || $self)) {
                $r['disabled'] = true;
            }

            $roles[$r['id']] = $r;
        }

        return $roles;
    }
}
