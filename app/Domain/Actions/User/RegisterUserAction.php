<?php

namespace App\Domain\Actions\User;

use App\Domain\DTOs\User\User;
use App\Domain\Exceptions\AppException;
use App\Domain\Repositories\UserRepository;

class RegisterUserAction
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(User $user): User
    {
        if (! filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new AppException('errors.user.invalidEmail', 500);
        }

        $user = $user->withHashedPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));

        return $this->userRepository->register($user);
    }
}
