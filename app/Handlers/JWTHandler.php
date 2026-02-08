<?php

namespace App\Handlers;

use App\Domain\Contracts\Auth\Authenticatable;
use App\Domain\DTOs\Auth\Token;
use App\Domain\Enums\Auth\Type;
use App\Domain\Exceptions\AppException;
use App\Domain\Services\JWTService;
use DateTimeImmutable;

class JWTHandler implements JWTService
{
    public function generate(Authenticatable $authenticatable, Type $type): Token
    {
        $now = new DateTimeImmutable;
        $expiration = null;
        $maxRefresh = null;

        if ($type->ttl()) {
            $expiration = $now->modify("+{$type->ttl()} seconds");
            $maxRefresh = $now->modify("+{env('JWT_MAX_REFRESH')} seconds");
        }

        $payload = [
            'sub' => $authenticatable->getId(),
            'email' => $authenticatable->getEmail(),
            'typ' => $type->value,
            'iat' => $now->getTimestamp(),
            'exp' => $expiration?->getTimestamp(),
            'mrf' => $maxRefresh?->getTimestamp(),
        ];

        $jwt = $this->encode($payload);

        return new Token(
            $jwt,
            $authenticatable->getId(),
            $authenticatable->getEmail(),
            $type,
            $expiration,
            $maxRefresh
        );
    }

    public function refresh(Token $token): Token
    {
        $now = new DateTimeImmutable;

        if (! $token->getMaxRefresh()) {
            throw new AppException('errors.auth.tokenNotRefreshable');
        }

        if ($token->getMaxRefresh() < $now) {
            throw new AppException('errors.auth.expiredToken');
        }

        if (! $token->getType()->ttl()) {
            throw new AppException('errors.auth.tokenNotRefreshable');
        }

        $expiration = $now->modify("+{$token->getType()->ttl()} seconds");

        $payload = [
            'sub' => $token->getAuthenticatableId(),
            'email' => $token->getEmail(),
            'typ' => $token->getType()->value,
            'iat' => $now->getTimestamp(),
            'exp' => $expiration->getTimestamp(),
            'mrf' => $token->getMaxRefresh()->getTimestamp(),
        ];

        $jwt = $this->encode($payload);

        return new Token(
            $jwt,
            $token->getAuthenticatableId(),
            $token->getEmail(),
            $token->getType(),
            $expiration,
            $token->getMaxRefresh()
        );
    }

    public function parse(string $token): Token
    {
        $payload = $this->decode($token);

        return new Token(
            $token,
            $payload['sub'],
            $payload['email'],
            Type::from($payload['typ']),
            isset($payload['exp']) ? new DateTimeImmutable('@'.$payload['exp']) : null,
            isset($payload['mrf']) ? new DateTimeImmutable('@'.$payload['mrf']) : null
        );
    }

    private function encode(array $payload): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $base64Header = $this->base64UrlEncode(json_encode($header));
        $base64Payload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac(
            'sha256',
            "$base64Header.$base64Payload",
            env('JWT_SECRET'),
            true
        );

        return $base64Header
            .'.'
            .$base64Payload
            .'.'
            .$this->base64UrlEncode($signature);
    }

    private function decode(string $jwt): array
    {
        $parts = explode('.', $jwt);

        if (count($parts) !== 3) {
            throw new AppException('errors.auth.invalidTokenFormat');
        }

        [$header, $payload, $signature] = $parts;

        $expected = $this->base64UrlEncode(
            hash_hmac(
                'sha256',
                "$header.$payload",
                env('JWT_SECRET'),
                true
            )
        );

        if (! hash_equals($expected, $signature)) {
            throw new AppException('errors.auth.invalidSignature');
        }

        $data = json_decode(
            $this->base64UrlDecode($payload),
            true
        );

        if (! $data) {
            throw new AppException('errors.auth.invalidTokenPayload');
        }

        if (isset($data['exp']) && $data['exp'] < time()) {
            throw new AppException('errors.auth.expiredToken');
        }

        return $data;
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
