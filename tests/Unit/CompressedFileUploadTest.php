<?php

declare(strict_types=1);

use Filament\Forms\Components\FileUpload;
use JuniorCastr\FilamentImageCompression\Components\CompressedFileUpload;

it('can create basic compressed file upload', function () {
    $component = CompressedFileUpload::make('image');

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('image');
});

it('can create compressed file upload with custom settings', function () {
    $component = CompressedFileUpload::makeWithSettings('banner', 1920, 85);

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('banner');
});

it('can create avatar compressed file upload', function () {
    $component = CompressedFileUpload::makeForAvatar('avatar');

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('avatar');
});

it('can create multiple compressed file upload', function () {
    $component = CompressedFileUpload::makeMultiple('gallery');

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('gallery')
        ->and($component->isMultiple())->toBeTrue();
});

it('can set compression settings', function () {
    $component = CompressedFileUpload::make('image')
        ->compressionSettings(1200, 90);

    expect($component)->toBeInstanceOf(CompressedFileUpload::class);
});

it('can set max width', function () {
    $component = CompressedFileUpload::make('image')
        ->maxWidth('1500');

    expect($component)->toBeInstanceOf(CompressedFileUpload::class);
});

it('can set quality', function () {
    $component = CompressedFileUpload::make('image')
        ->quality(75);

    expect($component)->toBeInstanceOf(CompressedFileUpload::class);
});

it('extends filament file upload', function () {
    $component = CompressedFileUpload::make('image');

    expect($component)->toBeInstanceOf(FileUpload::class);
});

it('can chain methods like regular file upload', function () {
    $component = CompressedFileUpload::make('image')
        ->label('Profile Image')
        ->directory('profiles')
        ->acceptedFileTypes(['image/jpeg', 'image/png'])
        ->maxSize(5120)
        ->compressionSettings(1920, 80);

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getLabel())->toBe('Profile Image');
});
