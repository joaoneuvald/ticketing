<?php

namespace App\Models;

use App\Domain\DTOs\User\User as DTO;
use App\Domain\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements UserRepository
{
    protected $table = 'tck_users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'blocked',
        'readonly',
    ];

    public function register(DTO $user): DTO
    {
        return DTO::fromArray($this->create($user->toArray())->toArray());
    }

    public function getByUsername(string $username): ?DTO
    {
        $model = $this->where('username', $username)->first();

        if (! $model) {
            return null;
        }

        return DTO::fromArray($model->toArray());
    }
}
