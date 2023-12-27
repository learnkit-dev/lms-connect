<?php

namespace LearnKit\LmsConnect;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use LearnKit\Lms\Facades\PluginManager;
use LearnKit\LmsConnect\Console\CreateApiTokenCommand;

class LmsConnectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        Config::set('auth.guards.lms-connect', [
            'driver' => 'passport',
            'provider' => 'users',
        ]);

        Config::set('passport.guard', 'lms-connect');

        Passport::ignoreRoutes();

        $this->publishes([
            __DIR__.'/../resources/views/vendor/passport' => resource_path('views/vendor/passport'),
        ], 'lms-connect-views');
    }

    public function boot(): void
    {
        if (! class_exists(PluginManager::class)) {
            return;
        }

        PluginManager::register(ConnectPlugin::class);

        $this->commands([
            CreateApiTokenCommand::class,
        ]);

        Passport::tokensCan([
            'email' => 'Je email adres lezen',
        ]);
    }
}