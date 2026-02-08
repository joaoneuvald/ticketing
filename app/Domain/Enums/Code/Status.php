<?php

namespace App\Domain\Enums\Code;

enum Status: int
{
    case AVAILABLE = 1;
    case USED = 2;
    case EXPIRED = 3;
}
