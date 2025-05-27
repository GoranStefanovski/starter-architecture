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
            UserPermissions::READ_EVENTS,
            UserPermissions::WRITE_EVENTS,
            UserPermissions::DELETE_EVENTS,
        ],
        //Artist
        UserRoles::COLLABORATOR => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::READ_VENUES,
            UserPermissions::READ_EVENTS,
            UserPermissions::WRITE_EVENTS,
            UserPermissions::DELETE_EVENTS,
        ],
        //Venue owner
        UserRoles::ORGANIZATION => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::READ_VENUES,
            UserPermissions::WRITE_VENUES,
            UserPermissions::DELETE_VENUES,
            UserPermissions::READ_EVENTS,
            UserPermissions::WRITE_EVENTS,
            UserPermissions::DELETE_EVENTS,
        ],
        //Registered User, can comment, vote etc.
        UserRoles::PUBLIC => [
            UserPermissions::WRITE_PUBLIC,
        ],
    ];
}
