<?php

namespace App\Enums;

use App\Traits\HasEnumValues;

enum CommentStatus: string
{
    use HasEnumValues;

    case PENDING = 'pending';
    case Accepted = 'accepted';
    case REVIEWING_BY_ADMIN = 'reviewing by admin';
    case NOT_CONFIRMED = 'not confirmed';

}
