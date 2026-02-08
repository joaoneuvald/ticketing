<?php

namespace App\Domain\Repositories;

use App\Domain\DTOs\Code\Code;
use App\Domain\Enums\Code\Type;

interface CodeRepository
{
    public function register(string $authenticatableId, Type $type): Code;

    public function retrieve(string $code, $authenticatable, Type $type): ?Code;
}
