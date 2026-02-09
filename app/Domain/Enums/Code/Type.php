<?php

namespace App\Domain\Enums\Code;

enum Type: int
{
    case LOGIN_CONFIRMATION = 1;

    public function ttl(): ?int
    {
        return match ($this) {
            self::LOGIN_CONFIRMATION => 300,
        };
    }
}
