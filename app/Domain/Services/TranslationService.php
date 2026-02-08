<?php

namespace App\Domain\Services;

interface TranslationService
{
    public function translate(?string $message): ?string;
}
