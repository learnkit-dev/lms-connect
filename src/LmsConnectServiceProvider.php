<?php

namespace LearnKit\LmsConnect;

use Illuminate\Support\ServiceProvider;

class LmsConnectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}