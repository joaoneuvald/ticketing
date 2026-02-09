<?php

namespace App\Providers;

use App\Domain\Repositories\CodeRepository;
use App\Domain\Repositories\UserRepository;
use App\Models\Code;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__.'../Domain/Translations');

        // Bindings

        $this->app->bind(UserRepository::class, User::class);
        $this->app->bind(CodeRepository::class, Code::class);
    }
}
