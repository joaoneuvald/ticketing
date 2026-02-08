<?php

namespace App\Domain\Repositories;

use App\Domain\DTOs\User\User;

interface UserRepository {
    public function register(User $user): User;
}
