<?php

namespace App\Constants;

use App\Constants\UserPermissions;
use App\Constants\UserRoles;

class RolePermissionsMap
{
    public const MAP = [
        UserRoles::ADMIN => [
            UserPermissions::READ_USERS,
            UserPermissions::WRITE_USERS,
            UserPermissions::DELETE_USERS,
            UserPermissions::READ_NAVIGATION,
            UserPermissions::WRITE_NAVIGATION,
            UserPermissions::DELETE_NAVIGATION,
            UserPermissions::READ_STORE,
            UserPermissions::WRITE_STORE,
            UserPermissions::DELETE_STORE,
        ],
        UserRoles::EDITOR => [
            UserPermissions::READ_USERS,
            UserPermissions::READ_NAVIGATION,
            UserPermissions::WRITE_NAVIGATION,
        ],
        UserRoles::COLLABORATOR => [
            UserPermissions::READ_NAVIGATION,
            UserPermissions::READ_STORE,
            UserPermissions::WRITE_STORE,
        ],
    ];
}
