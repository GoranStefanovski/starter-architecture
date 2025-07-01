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
            UserPermissions::WRITE_PUBLIC,
            UserPermissions::WRITE_CONTACT_INFO,
        ],
        //Venue owner and Event owner
        UserRoles::COLLABORATOR => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::READ_VENUES,
            UserPermissions::WRITE_VENUES,
            UserPermissions::READ_EVENTS,
            UserPermissions::WRITE_EVENTS,
            UserPermissions::DELETE_EVENTS,
            UserPermissions::WRITE_PUBLIC,
        ],
        // Event owner
        UserRoles::ORGANIZATION => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::READ_EVENTS,
            UserPermissions::WRITE_EVENTS,
            UserPermissions::DELETE_EVENTS,
            UserPermissions::WRITE_PUBLIC,
            UserPermissions::WRITE_CONTACT_INFO,
        ],
        // Manage artist profile
        UserRoles::ARTIST => [
            UserPermissions::DASHBOARD_VIEW,
            UserPermissions::WRITE_PUBLIC,
            UserPermissions::WRITE_CONTACT_INFO,
        ],
        //Registered user, can comment, vote etc.
        UserRoles::PUBLIC => [
            UserPermissions::WRITE_PUBLIC,
        ],
    ];
}
