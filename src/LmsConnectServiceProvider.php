<?php

namespace LearnKit\LmsConnect;

use Illuminate\Support\ServiceProvider;
use LearnKit\LmsConnect\Contracts\GroupRepository;

class LmsConnectServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}