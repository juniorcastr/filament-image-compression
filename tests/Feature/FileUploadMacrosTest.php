<?php

declare(strict_types=1);

use Filament\Forms\Components\FileUpload;
use JuniorCastr\FilamentImageCompression\Components\CompressedFileUpload;

it('can use compressed macro', function () {
    $component = FileUpload::make('image')->compressed();

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('image');
});

it('can use compressedAvatar macro', function () {
    $component = FileUpload::make('avatar')->compressedAvatar();

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('avatar');
});

it('can use compressedMultiple macro', function () {
    $component = FileUpload::make('gallery')->compressedMultiple();

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('gallery')
        ->and($component->isMultiple())->toBeTrue();
});

it('can use compressedWithSettings macro', function () {
    $component = FileUpload::make('banner')->compressedWithSettings(1920, 85);

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getName())->toBe('banner');
});

it('macros preserve existing configuration', function () {
    $component = FileUpload::make('image')
        ->label('Test Image')
        ->compressed();

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getLabel())->toBe('Test Image');
});

it('can chain methods after using macros', function () {
    $component = FileUpload::make('image')
        ->compressed()
        ->label('Compressed Image');

    expect($component)->toBeInstanceOf(CompressedFileUpload::class)
        ->and($component->getLabel())->toBe('Compressed Image');
});
