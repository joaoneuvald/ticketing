<?php

namespace App\Handlers;

use App\Domain\Services\TranslationService;

class TranslationHandler implements TranslationService
{
    public function translate(?string $message): ?string
    {
        return ! is_null($message) ? __($message) : null;
    }
}
