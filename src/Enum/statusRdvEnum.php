<?php

namespace App\Enum;

enum statusRdvEnum: string
{
    case Confirmed = 'Confirmed';
    case Validated = 'Validated';
    case Annuled = 'Annuled';
    case Missed = 'Missed';
}