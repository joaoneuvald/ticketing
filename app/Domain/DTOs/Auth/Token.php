<?php

namespace App\Domain\DTOs\Auth;

use App\Domain\Enums\Auth\Role;
use App\Domain\Enums\Auth\Type;
use DateTimeImmutable;

class Token
{
    private string $token;

    private string $authenticatableId;

    private string $email;

    private Role $role;

    private Type $type;

    private ?DateTimeImmutable $expiration;

    private ?DateTimeImmutable $maxRefresh;

    public function __construct(
        string $token,
        string $authenticatableId,
        string $email,
        Role $role,
        Type $type,
        ?DateTimeImmutable $expiration,
        ?DateTimeImmutable $maxRefresh
    ) {
        $this->token = $token;
        $this->authenticatableId = $authenticatableId;
        $this->email = $email;
        $this->role = $role;
        $this->type = $type;
        $this->expiration = $expiration;
        $this->maxRefresh = $maxRefresh;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'user_id' => $this->authenticatableId,
            'email' => $this->email,
            'role' => $this->role->value,
        ];
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getAuthenticatableId(): string
    {
        return $this->authenticatableId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getExpiration(): ?DateTimeImmutable
    {
        return $this->expiration;
    }

    public function getMaxRefresh(): ?DateTimeImmutable
    {
        return $this->maxRefresh;
    }
}
