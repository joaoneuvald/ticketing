<?php

namespace App\Domain\Enums\Auth;

enum Role: int
{
    case ADMIN = 1;
    case ORGANIZER = 2;
    case CUSTOMER = 3;
}
