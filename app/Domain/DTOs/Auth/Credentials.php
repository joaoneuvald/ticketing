<?php

namespace App\Domain\DTOs\Auth;

class Credentials
{
    private string $username;

    private string $password;

    private bool $isAdmin;

    public function __construct(
        string $username,
        string $password,
        bool $isAdmin
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->isAdmin = $isAdmin;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }
}
