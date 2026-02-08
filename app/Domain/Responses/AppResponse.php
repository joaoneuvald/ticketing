<?php

namespace App\Domain\Responses;

class AppResponse
{
    private ?string $message;

    private ?array $data;

    private int $code;

    public function __construct(
        ?string $message = null,
        ?array $data = null,
        int $code = 200
    ) {
        $this->message = $message;
        $this->data = $data;
        $this->code = $code;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    public function getCode(): int
    {
        return $this->code;
    }
}
