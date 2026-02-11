<?php

namespace App\Enums;

enum SlotStatus: string
{
    case Available = 'available';
    case Booked = 'booked';
    case Pending = 'pending';

    public function label(): string
    {
        return match($this) {
            self::Available => 'Available',
            self::Booked => 'Booked',
            self::Pending => 'Pending',
        };
    }
}
