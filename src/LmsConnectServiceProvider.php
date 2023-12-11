<?php

namespace LearnKit\LmsConnect;

use Illuminate\Support\ServiceProvider;
use LearnKit\Lms\Facades\PluginManager;
use LearnKit\LmsConnect\Console\CreateApiTokenCommand;

class LmsConnectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    public function boot(): void
    {
        PluginManager::register(ConnectPlugin::class);

        $this->commands([
            CreateApiTokenCommand::class,
        ]);
    }
}