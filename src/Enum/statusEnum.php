<?php

namespace App\Enum;

enum statusEnum: string
{
    case Pending = 'Pending';
    case Active = 'Active';
    case Denied = 'Denied';
}