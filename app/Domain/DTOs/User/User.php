<?php

namespace App\Domain\DTOs\User;

use App\Domain\Enums\Auth\Role;
use App\Domain\Exceptions\AppException;

class User
{
    private ?string $id;

    private string $username;

    private string $email;

    private string $name;

    private string $password;

    private Role $role;

    private bool $blocked;

    private bool $readonly;

    public function __construct(
        ?string $id,
        string $username,
        string $email,
        string $name,
        string $password,
        Role $role,
        bool $blocked,
        bool $readonly
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
        $this->blocked = $blocked;
        $this->readonly = $readonly;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function isBlocked(): bool
    {
        return $this->blocked;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role->value,
            'blocked' => $this->blocked,
            'readonly' => $this->readonly,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            $data['user_id'] ?? null,
            $data['username'],
            $data['email'],
            $data['name'],
            $data['password'],
            Role::tryFrom($data['role']),
            $data['blocked'] ?? false,
            $data['readonly'] ?? false
        );
    }

    public function withHashedPassword(string $password): static {
        $new = clone $this;
        $new->password = password_hash($password, PASSWORD_DEFAULT);
        return $new;
    }
}
