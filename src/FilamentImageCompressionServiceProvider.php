<?php

namespace CondoSmart\FilamentImageCompression;

use CondoSmart\FilamentImageCompression\Components\CompressedFileUpload;
use CondoSmart\FilamentImageCompression\Services\ImageCompressionService;
use Filament\Forms\Components\FileUpload;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentImageCompressionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('filament-image-compression');
    }

    public function packageBooted(): void
    {
        // Registra o serviço de compressão de imagens
        $this->app->singleton(ImageCompressionService::class);

        // Adiciona macro 'compressed' para FileUpload
        FileUpload::macro('compressed', function () {
            return CompressedFileUpload::make($this->getName());
        });

        // Adiciona macro 'compressedAvatar' para FileUpload
        FileUpload::macro('compressedAvatar', function () {
            return CompressedFileUpload::makeForAvatar($this->getName());
        });

        // Adiciona macro 'compressedMultiple' para FileUpload
        FileUpload::macro('compressedMultiple', function () {
            return CompressedFileUpload::makeMultiple($this->getName());
        });

        // Adiciona macro 'compressedWithSettings' para FileUpload
        FileUpload::macro('compressedWithSettings', function (int $maxWidth = 1920, int $quality = 80) {
            return CompressedFileUpload::makeWithSettings($this->getName(), $maxWidth, $quality);
        });
    }
}