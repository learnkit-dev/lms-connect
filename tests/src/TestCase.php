<?php

namespace LearnKit\LmsConnect\Tests;

use Filament\FilamentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Laravel\Pennant\PennantServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use LearnKit\Lms\LmsServiceProvider;
use LearnKit\LmsConnect\LmsConnectServiceProvider;
use LearnKit\LmsConnect\Tests\Models\User;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\LaravelRay\RayServiceProvider;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use LazilyRefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LearnKit\\Lms\\Database\\Factories\\' . class_basename($modelName) . 'Factory',
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            RayServiceProvider::class,
            PennantServiceProvider::class,
            LivewireServiceProvider::class,
            LaravelSettingsServiceProvider::class,
            FilamentServiceProvider::class,
            SanctumServiceProvider::class,
            LmsServiceProvider::class,
            LmsConnectServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('lms.user_model', User::class);
        $app['config']->set('app.url', "https://cursuskit.test");
    }
}
