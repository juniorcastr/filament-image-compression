<?php

declare(strict_types=1);

namespace JuniorCastr\FilamentImageCompression\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

/**
 * Image Compression Service
 *
 * Handles automatic image compression and WebP conversion
 * using Intervention Image library.
 */
class ImageCompressionService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    /**
     * Compress and convert image to WebP format
     */
    public function compressImage(
        UploadedFile $file,
        string $disk = 'public',
        string $path = '',
        int $maxWidth = 1920,
        int $quality = 80
    ): string {
        // Validate that the file is an image
        if (! $this->isImage($file)) {
            throw new \InvalidArgumentException('File is not a valid image.');
        }

        // Load the image
        $image = $this->manager->read($file->getPathname());

        // Resize maintaining aspect ratio
        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        // Generate unique filename for WebP file
        $filename = Str::uuid().'.webp';
        $fullPath = $path ? $path.'/'.$filename : $filename;

        // Convert to WebP with specified quality
        $webpData = $image->toWebp($quality);

        // Save to storage
        Storage::disk($disk)->put($fullPath, $webpData);

        return $fullPath;
    }

    /**
     * Check if the uploaded file is a valid image
     */
    private function isImage(UploadedFile $file): bool
    {
        $allowedMimes = [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/bmp',
        ];

        return in_array($file->getMimeType(), $allowedMimes, true);
    }

    /**
     * Get information about the compressed image
     */
    public function getImageInfo(string $path, string $disk = 'public'): array
    {
        if (! Storage::disk($disk)->exists($path)) {
            throw new \InvalidArgumentException('File not found.');
        }

        $fullPath = Storage::disk($disk)->path($path);
        $image = $this->manager->read($fullPath);

        return [
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => Storage::disk($disk)->size($path),
            'mime_type' => 'image/webp',
            'format' => 'webp',
        ];
    }

    /**
     * Calculate compression ratio
     */
    public function getCompressionRatio(string $originalPath, string $compressedPath, string $disk = 'public'): float
    {
        $originalSize = Storage::disk($disk)->size($originalPath);
        $compressedSize = Storage::disk($disk)->size($compressedPath);

        if ($originalSize === 0) {
            return 0;
        }

        return round((1 - ($compressedSize / $originalSize)) * 100, 2);
    }
}
