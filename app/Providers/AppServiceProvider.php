<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use MoonShine\Models\MoonShineUser;

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
        // Обработка создания администратора
        MoonShineUser::created(function (MoonShineUser $moonshineUser) {
            $existingUser = User::where('email', $moonshineUser->email)->first();

            if (!$existingUser) {
                User::create([
                    'name' => $moonshineUser->name,
                    'email' => $moonshineUser->email,
                    'password' => $moonshineUser->password,
                    'role' => 'admin',
                ]);
            }
        });

        // Обработка обновления администратора
        MoonShineUser::updated(function (MoonShineUser $moonshineUser) {
            $localUser = User::where('email', $moonshineUser->email)->first();

            if ($localUser) {
                $localUser->update([
                    'name' => $moonshineUser->name,
                    'password' => $moonshineUser->password, // Обновляем, если нужно
                ]);
            }
        });

        // Обработка удаления администратора
        MoonShineUser::deleted(function (MoonShineUser $moonshineUser) {
            User::where('email', $moonshineUser->email)->delete();
        });
    }
}
