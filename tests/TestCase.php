<?php

declare(strict_types=1);

namespace JuniorCastr\FilamentImageCompression\Tests;

use Filament\FilamentServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use JuniorCastr\FilamentImageCompression\FilamentImageCompressionServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JuniorCastr\\FilamentImageCompression\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            FilamentImageCompressionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        config()->set('filesystems.disks.testing', [
            'driver' => 'local',
            'root' => storage_path('framework/testing/disks/testing'),
        ]);

        config()->set('filesystems.default', 'local');
    }
}
