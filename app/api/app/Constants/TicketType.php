<?php

namespace App\Constants;

class TicketType
{
    public const FREE_ENTRY = 'free_entry';
    public const GENERAL = 'general';
    public const VIP = 'vip';
    public const EARLY_ACCESS = 'early_access';

    public const TYPES = [
        self::FREE_ENTRY,
        self::GENERAL,
        self::VIP,
        self::EARLY_ACCESS,
    ];
}
