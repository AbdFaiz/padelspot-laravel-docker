<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Verified = 'verified';
    case Rejected = 'rejected';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
