<?php

namespace App\Domain\Enums\Auth;

enum Type: int {
    case ACCESS = 1;
    case REFRESH = 2;
    case INFINITE = 3;
}