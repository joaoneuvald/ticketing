<?php

namespace App\Domain\DTOs\Auth;

use App\Domain\Enums\Auth\Type;
use DateTimeImmutable;

class Token {
    private string $token;
    private string $authenticatableId;
    private string $email;
    private Type $type;
    private DateTimeImmutable|null $expiration;
    private DateTimeImmutable|null $maxRefresh;

    public function __construct(
        string $token,
        string $authenticatableId,
        string $email,
        Type $type,
        DateTimeImmutable|null $expiration,
        DateTimeImmutable|null $maxRefresh
    ) {
        $this->token = $token;
        $this->authenticatableId = $authenticatableId;
        $this->email = $email;
        $this->type = $type;
        $this->expiration = $expiration;
        $this->maxRefresh = $maxRefresh;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function getAuthenticatableId(): string
    {
        return $this->authenticatableId;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getType(): Type {
        return $this->type;
    }

    public function getExpiration(): DateTimeImmutable|null {
        return $this->expiration;
    }

    public function getMaxRefresh(): DateTimeImmutable|null {
        return $this->maxRefresh;
    }
}