<?php

declare(strict_types=1);

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JuniorCastr\FilamentImageCompression\Services\ImageCompressionService;

beforeEach(function () {
    $this->service = new ImageCompressionService;
    Storage::fake('testing');
});

it('can compress a JPEG image', function () {
    $file = UploadedFile::fake()->image('test.jpg', 2000, 1500);

    $result = $this->service->compressImage($file, 'testing', 'images', 1920, 80);

    expect($result)->toBeString()
        ->and($result)->toEndWith('.webp')
        ->and(Storage::disk('testing')->exists($result))->toBeTrue();
});

it('can compress a PNG image', function () {
    $file = UploadedFile::fake()->image('test.png', 1500, 1000);

    $result = $this->service->compressImage($file, 'testing', 'images', 1920, 85);

    expect($result)->toBeString()
        ->and($result)->toEndWith('.webp')
        ->and(Storage::disk('testing')->exists($result))->toBeTrue();
});

it('respects maximum width settings', function () {
    $file = UploadedFile::fake()->image('large.jpg', 3000, 2000);

    $result = $this->service->compressImage($file, 'testing', 'images', 1200, 80);

    expect($result)->toBeString();

    $info = $this->service->getImageInfo($result, 'testing');
    expect($info['width'])->toBeLessThanOrEqual(1200);
});

it('maintains aspect ratio when resizing', function () {
    $file = UploadedFile::fake()->image('test.jpg', 2000, 1000); // 2:1 ratio

    $result = $this->service->compressImage($file, 'testing', 'images', 1000, 80);

    $info = $this->service->getImageInfo($result, 'testing');
    $ratio = $info['width'] / $info['height'];

    expect(abs($ratio - 2.0))->toBeLessThan(0.1);
});

it('throws exception for non-image files', function () {
    $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');

    expect(fn () => $this->service->compressImage($file, 'testing'))
        ->toThrow(InvalidArgumentException::class, 'File is not a valid image.');
});

it('can get image information', function () {
    $file = UploadedFile::fake()->image('test.jpg', 800, 600);
    $path = $this->service->compressImage($file, 'testing', 'images');

    $info = $this->service->getImageInfo($path, 'testing');

    expect($info)->toHaveKeys(['width', 'height', 'size', 'mime_type', 'format'])
        ->and($info['mime_type'])->toBe('image/webp')
        ->and($info['format'])->toBe('webp')
        ->and($info['width'])->toBeInt()
        ->and($info['height'])->toBeInt()
        ->and($info['size'])->toBeInt();
});

it('throws exception when getting info for non-existent file', function () {
    expect(fn () => $this->service->getImageInfo('non-existent.webp', 'testing'))
        ->toThrow(InvalidArgumentException::class, 'File not found.');
});

it('can calculate compression ratio', function () {
    // Create a large original file
    $originalFile = UploadedFile::fake()->image('original.jpg', 2000, 1500);
    Storage::disk('testing')->put('original.jpg', $originalFile->getContent());

    // Compress it
    $compressedPath = $this->service->compressImage($originalFile, 'testing', 'compressed');

    $ratio = $this->service->getCompressionRatio('original.jpg', $compressedPath, 'testing');

    expect($ratio)->toBeFloat()
        ->and($ratio)->toBeGreaterThan(0)
        ->and($ratio)->toBeLessThan(100);
});

it('handles different quality settings', function () {
    $file = UploadedFile::fake()->image('test.jpg', 1000, 800);

    $lowQuality = $this->service->compressImage($file, 'testing', 'low', 1920, 30);
    $highQuality = $this->service->compressImage($file, 'testing', 'high', 1920, 95);

    $lowSize = Storage::disk('testing')->size($lowQuality);
    $highSize = Storage::disk('testing')->size($highQuality);

    // Allow for some tolerance in file sizes due to compression algorithms
    expect($lowSize)->toBeLessThanOrEqual($highSize + 100);
});

it('generates unique filenames', function () {
    $file1 = UploadedFile::fake()->image('test1.jpg', 800, 600);
    $file2 = UploadedFile::fake()->image('test2.jpg', 800, 600);

    $path1 = $this->service->compressImage($file1, 'testing', 'images');
    $path2 = $this->service->compressImage($file2, 'testing', 'images');

    expect($path1)->not->toBe($path2);
});
