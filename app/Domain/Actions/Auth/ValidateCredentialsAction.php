<?php

namespace App\Domain\Actions\Auth;

use App\Domain\Contracts\Auth\Authenticatable;
use App\Domain\DTOs\Auth\Credentials;
use App\Domain\Repositories\UserRepository;

class ValidateCredentialsAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Credentials $credentials): Authenticatable
    {
        $repository = $this->userRepository;

        if (! $credentials->isAdmin()) {
            // TODO: Implement customer module
        }

        $authenticatable = $repository->getByUsername($credentials->getUsername());

        if (! $authenticatable || ! password_verify($credentials->getPassword(), $authenticatable->getPassword())) {
            throw new \Exception('errors.auth.invalidCredentials');
        }

        return $authenticatable;
    }
}
