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
            UserPermissions::READ_VENUES,
            UserPermissions::WRITE_VENUES,
            UserPermissions::DELETE_VENUES,
        ],
        UserRoles::COLLABORATOR => [
            UserPermissions::READ_VENUES,
            UserPermissions::WRITE_VENUES,
            UserPermissions::DELETE_VENUES,
        ],
        UserRoles::ORGANIZATION => [
            UserPermissions::READ_USERS,
            UserPermissions::READ_NAVIGATION,
            UserPermissions::WRITE_NAVIGATION,
        ],
    ];
}
