<?php

namespace App\Constants;

class UserPermissions
{
    // Dashboard
    public const DASHBOARD_VIEW = 'dashboard_view';

    // Users module
    public const READ_USERS = 'read_users';
    public const WRITE_USERS = 'write_users';
    public const DELETE_USERS = 'delete_users';

    // Venue module
    public const READ_VENUES = 'read_venues';
    public const WRITE_VENUES = 'write_venues';
    public const DELETE_VENUES = 'delete_venues';

    // Public Users
    public const WRITE_PUBLIC = 'WRITE_PUBLIC';

    // Navigation module
    public const READ_NAVIGATION = 'read_navigation';
    public const WRITE_NAVIGATION = 'write_navigation';
    public const DELETE_NAVIGATION = 'delete_navigation';
}
