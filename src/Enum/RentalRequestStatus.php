<?php

namespace App\Enum;

enum RentalRequestStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public function colorClass(): string
    {
        return match($this) {
            self::PENDING => 'text-warning',
            self::APPROVED => 'text-success',
            self::REJECTED => 'text-danger',
            self::COMPLETED => 'text-info',
            self::CANCELED => 'text-secondary',
        };
    }
}