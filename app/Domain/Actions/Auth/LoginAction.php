<?php

namespace App\Domain\Actions\Auth;

use App\Domain\DTOs\Auth\Credentials;

class LoginAction
{
    private ValidateCredentialsAction $validateCredentials;

    public function __construct(ValidateCredentialsAction $validateCredentials)
    {
        $this->validateCredentials = $validateCredentials;
    }

    public function execute(Credentials $credentials): void
    {
        $authenticatable = $this->validateCredentials->execute($credentials);

    }
}
