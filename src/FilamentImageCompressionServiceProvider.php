<?php

declare(strict_types=1);

namespace JuniorCastr\FilamentImageCompression;

use Filament\Forms\Components\FileUpload;
use JuniorCastr\FilamentImageCompression\Components\CompressedFileUpload;
use JuniorCastr\FilamentImageCompression\Services\ImageCompressionService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Service Provider for Filament Image Compression Plugin
 *
 * This provider registers the image compression service and adds convenient
 * macros to the FileUpload component for automatic image compression.
 */
class FilamentImageCompressionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-image-compression')
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        $this->registerServices();
        $this->registerMacros();
    }

    /**
     * Register the image compression service as singleton
     */
    protected function registerServices(): void
    {
        $this->app->singleton(ImageCompressionService::class);
    }

    /**
     * Register FileUpload macros for compressed uploads
     */
    protected function registerMacros(): void
    {
        // Basic compressed upload
        FileUpload::macro('compressed', function () {
            /** @var FileUpload $this */
            $compressed = CompressedFileUpload::make($this->getName());

            // Only transfer label to avoid disk issues
            if ($this->getLabel()) {
                $compressed->label($this->getLabel());
            }

            return $compressed;
        });

        // Compressed avatar upload (circular, single file)
        FileUpload::macro('compressedAvatar', function () {
            return CompressedFileUpload::makeForAvatar($this->getName());
        });

        // Compressed multiple files upload
        FileUpload::macro('compressedMultiple', function () {
            return CompressedFileUpload::makeMultiple($this->getName());
        });

        // Compressed upload with custom settings
        FileUpload::macro('compressedWithSettings', function (int $maxWidth = 1920, int $quality = 80) {
            return CompressedFileUpload::makeWithSettings($this->getName(), $maxWidth, $quality);
        });
    }
}
