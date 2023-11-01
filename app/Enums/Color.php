<?php

namespace App\Enums;

use App\Traits\HasEnumValues;

enum Color: string
{
    use HasEnumValues;

    case PINK = "pink";
    case PURPLE = "purple";
    case BLUE = "blue";
    case GRAY = "gray";
    case VIOLET = "violet";
}
