<?php

namespace App\Domain\Enums\Auth;

enum Type: int
{
    case ACCESS = 1;
    case REFRESH = 2;
    case INFINITE = 3;

    public function ttl(): ?int
    {
        return match ($this) {
            self::ACCESS => 900,
            self::REFRESH => 28800,
            self::INFINITE => null,
        };
    }
}
