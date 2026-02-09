<?php

namespace App\Models;

use App\Domain\DTOs\Code\Code as DTO;
use App\Domain\Enums\Code\Status;
use App\Domain\Enums\Code\Type;
use App\Domain\Exceptions\AppException;
use App\Domain\Repositories\CodeRepository;
use Illuminate\Database\Eloquent\Model;

class Code extends Model implements CodeRepository
{
    protected $table = 'tck_codes';

    protected $primaryKey = 'code_id';

    protected $fillable = [
        'code',
        'authenticatable_id',
        'type',
        'status',
        'expiration',
    ];

    public function register(string $authenticatableId, Type $type): DTO
    {
        return DTO::fromArray([
            'code' => rand(100000, 999999),
            'authenticatable_id' => $authenticatableId,
            'type' => $type->value,
            'status' => Status::AVAILABLE->value,
            'expiration' => empty($type->ttl()) ? null : now()->toDateTimeImmutable()->modify("+{$type->ttl()} seconds"),
        ]);
    }

    public function retrieve(string $code, string $authenticatableId, Type $type): ?DTO
    {
        $model = $this->newQuery()
            ->where('code', $code)
            ->where('type', $type->value)
            ->where('authenticatable_id', $authenticatableId)
            ->first();

        if (! $model) {
            return null;
        }

        return DTO::fromArray($model->toArray());
    }

    public function changeStatus(string $codeId, Status $status): bool
    {
        $model = $this->find($codeId);

        if (! $model) {
            throw new AppException('errors.code.invalidCode', 500);
        }

        $model->status = $status->value;

        return $model->updateOrFail();
    }
}
