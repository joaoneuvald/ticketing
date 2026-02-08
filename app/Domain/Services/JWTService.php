<?php

namespace App\Domain\Services;

use App\Domain\Contracts\Auth\Authenticatable;
use App\Domain\DTOs\Auth\Token;
use App\Domain\Enums\Auth\Type;

interface JWTService
{
    public function generate(Authenticatable $authenticatable, Type $type): Token;

    public function refresh(Token $token): Token;

    public function parse(string $token): Token;
}
