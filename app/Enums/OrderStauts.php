<?php

namespace App\Enums;

use App\Traits\HasEnumValues;

enum OrderStauts :string
{
    use HasEnumValues;

    case CHECKING = 'checking';
    case CANCELED = 'canceled';
    case PREPARING = 'preparing';
    case SHIPPING = 'shipping';
    case DELIVERED = 'delivered';
}
