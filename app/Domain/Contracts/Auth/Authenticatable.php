<?php

namespace App\Domain\Contracts\Auth;

use App\Domain\Enums\Auth\Role;

interface Authenticatable
{
    public function getId(): ?string;

    public function getEmail(): string;

    public function getPassword(): string;

    public function getUsername(): string;

    public function getRole(): Role;
}
