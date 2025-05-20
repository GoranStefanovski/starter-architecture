<?php

namespace App\Constants;

use App\Constants\UserPermissions;
use App\Constants\UserRoles;

class RolePermissionsMap
{
    public const MAP = [
        UserRoles::ADMIN => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::READ_USERS,
            UserPermissions::WRITE_USERS,
            UserPermissions::DELETE_USERS,
            UserPermissions::READ_VENUES,
            UserPermissions::WRITE_VENUES,
            UserPermissions::DELETE_VENUES,
        ],
        UserRoles::COLLABORATOR => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::READ_VENUES,
            UserPermissions::WRITE_VENUES,
            UserPermissions::DELETE_VENUES,
        ],
        UserRoles::ORGANIZATION => [
            UserPermissions::DASHBOARD_VIEW,
        ],
        // TBD: Remove Access for Public Users in Admin Dashboard
        UserRoles::PUBLIC => [
            UserPermissions::WRITE_PUBLIC,
        ],
    ];
}
