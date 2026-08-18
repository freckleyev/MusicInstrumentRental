<?php

namespace App\Enum;

enum RentalRequestStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';
}