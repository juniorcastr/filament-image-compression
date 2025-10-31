<?php

declare(strict_types=1);

namespace JuniorCastr\FilamentImageCompression\Components;

use Filament\Forms\Components\FileUpload;
use Illuminate\Http\UploadedFile;
use JuniorCastr\FilamentImageCompression\Services\ImageCompressionService;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Compressed File Upload Component
 *
 * Extends Filament's FileUpload component to automatically compress
 * and convert images to WebP format during upload.
 */
class CompressedFileUpload extends FileUpload
{
    protected int $compressionMaxWidth = 1920;

    protected int $quality = 80;

    protected function setUp(): void
    {
        parent::setUp();

        $this->saveUploadedFileUsing(function (TemporaryUploadedFile $file, callable $set) {
            $compressionService = app(ImageCompressionService::class);

            // Convert TemporaryUploadedFile to UploadedFile
            $uploadedFile = new UploadedFile(
                $file->getRealPath(),
                $file->getClientOriginalName(),
                $file->getMimeType(),
                null,
                true
            );

            // Check if file is an image before compressing
            if (! $this->isImage($uploadedFile)) {
                // If not an image, save normally
                return $file->store($this->getDirectory(), $this->getDiskName());
            }

            // Compress the image with custom settings
            $compressedPath = $compressionService->compressImage(
                $uploadedFile,
                $this->getDiskName(),
                $this->getDirectory(),
                $this->compressionMaxWidth,
                $this->quality
            );

            return $compressedPath;
        });
    }

    /**
     * Set compression settings
     */
    public function compressionSettings(int $maxWidth = 1920, int $quality = 80): static
    {
        $this->compressionMaxWidth = $maxWidth;
        $this->quality = $quality;

        return $this;
    }

    /**
     * Set compression quality
     */
    public function quality(int $quality): static
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Check if the uploaded file is an image
     */
    private function isImage(UploadedFile $file): bool
    {
        $allowedMimes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
        ];

        return in_array($file->getMimeType(), $allowedMimes, true);
    }

    /**
     * Create a compressed file upload instance
     */
    public static function make(?string $name = null): static
    {
        $static = parent::make($name);

        return $static
            ->disk('local') // Set default disk
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp',
                'image/bmp',
            ])
            ->image()
            ->imageEditor()
            ->maxSize(10240) // 10MB maximum
            ->helperText('Images will be automatically converted to WebP and compressed (1920px max, 80% quality).');
    }

    /**
     * Create instance with custom compression settings
     */
    public static function makeWithSettings(?string $name = null, int $maxWidth = 1920, int $quality = 80): static
    {
        return static::make($name)
            ->compressionSettings($maxWidth, $quality)
            ->helperText("Images will be automatically converted to WebP and compressed ({$maxWidth}px max, {$quality}% quality).");
    }

    /**
     * Create instance optimized for avatars
     */
    public static function makeForAvatar(?string $name = null): static
    {
        return static::make($name)
            ->avatar()
            ->imageEditor()
            ->circleCropper()
            ->compressionSettings(400, 85)
            ->helperText('Avatar will be automatically resized and compressed (400px max, 85% quality).');
    }

    /**
     * Create instance for multiple image uploads
     */
    public static function makeMultiple(?string $name = null): static
    {
        return static::make($name)
            ->multiple()
            ->reorderable()
            ->helperText('All images will be automatically converted to WebP and compressed.');
    }
}
