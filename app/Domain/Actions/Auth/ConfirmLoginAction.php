<?php

namespace App\Domain\Actions\Auth;

use App\Domain\DTOs\Auth\Credentials;
use App\Domain\DTOs\Auth\Token;
use App\Domain\Enums\Auth\Type as TokenType;
use App\Domain\Enums\Code\Status;
use App\Domain\Enums\Code\Type as CodeType;
use App\Domain\Exceptions\AppException;
use App\Domain\Repositories\CodeRepository;
use App\Domain\Services\JWTService;

class ConfirmLoginAction
{
    private CodeRepository $codeRepository;

    private ValidateCredentialsAction $validateCredentials;

    private JWTService $jwtService;

    public function __construct(
        CodeRepository $codeRepository,
        ValidateCredentialsAction $validateCredentials,
        JWTService $jwtService
    ) {
        $this->codeRepository = $codeRepository;
        $this->validateCredentials = $validateCredentials;
        $this->jwtService = $jwtService;
    }

    public function execute(Credentials $credentials, int $code): Token
    {
        $authenticatable = $this->validateCredentials->execute($credentials);

        $code = $this->codeRepository->retrieve($code, $authenticatable->getId(), CodeType::LOGIN_CONFIRMATION);

        if (! $code && $code->getStatus() != Status::AVAILABLE) {
            throw new AppException('errors.auth.invalidConfirmationCode', 500);
        }

        return $this->jwtService->generate($authenticatable, TokenType::ACCESS);
    }
}
