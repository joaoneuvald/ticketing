<?php

namespace App\Domain\DTOs\Code;

use App\Domain\Enums\Code\Status;
use App\Domain\Enums\Code\Type;
use DateTimeImmutable;

class Code
{
    private ?string $id;

    private int $code;

    private string $authenticatableId;

    private Status $status;

    private Type $type;

    private ?DateTimeImmutable $expiration;

    public function __construct(
        ?string $id,
        int $code,
        string $authenticatableId,
        Type $type,
        Status $status,
        ?DateTimeImmutable $expiration
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->authenticatableId = $authenticatableId;
        $this->type = $type;
        $this->status = $status;
        $this->expiration = $expiration;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['code_id'] ?? null,
            $data['code'] ?? 0,
            $data['authenticatable_id'],
            Type::tryFrom($data['type']),
            Status::tryFrom($data['status']),
            ! $data['expiration'] ? null : new DateTimeImmutable($data['expiration'])
        );
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getAuthenticatableId(): string
    {
        return $this->authenticatableId;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getExpiration(): ?DateTimeImmutable
    {
        return $this->expiration;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
