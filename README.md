# Filament Image Compression

[![Latest Version on Packagist](https://img.shields.io/packagist/v/juniorcastr/filament-image-compression.svg?style=flat-square)](https://packagist.org/packages/juniorcastr/filament-image-compression)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/juniorcastr/filament-image-compression/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/juniorcastr/filament-image-compression/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/juniorcastr/filament-image-compression/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/juniorcastr/filament-image-compression/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/juniorcastr/filament-image-compression.svg?style=flat-square)](https://packagist.org/packages/juniorcastr/filament-image-compression)
[![License](https://img.shields.io/packagist/l/juniorcastr/filament-image-compression.svg?style=flat-square)](https://packagist.org/packages/juniorcastr/filament-image-compression)

A powerful Filament plugin that automatically compresses and converts uploaded images to WebP format, reducing file sizes while maintaining quality. Perfect for optimizing storage and improving website performance.

## Features

- 🚀 **Automatic Compression**: Seamlessly compresses images on upload
- 🖼️ **WebP Conversion**: Converts images to modern WebP format for better compression
- ⚙️ **Configurable Settings**: Customize compression quality and maximum dimensions
- 📱 **Multiple Formats**: Supports JPEG, PNG, GIF, BMP, and WebP input formats
- 🎯 **Easy Integration**: Drop-in replacement for Filament's FileUpload component
- 🔧 **Flexible Configuration**: Per-component or global configuration options
- 📊 **Compression Analytics**: Track compression ratios and file size savings

## Installation

You can install the package via composer:

```bash
composer require juniorcastr/filament-image-compression
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-image-compression-config"
```

## Uso

### Uso Básico

```php
use Filament\Forms\Components\FileUpload;

// Upload com compressão automática
FileUpload::make('image')
    ->compressed()
    ->label('Imagem');
```

### Upload de Avatar

```php
FileUpload::make('avatar')
    ->compressedAvatar()
    ->label('Avatar');
```

### Upload Múltiplo

```php
FileUpload::make('gallery')
    ->compressedMultiple()
    ->label('Galeria de Imagens');
```

### Configurações Personalizadas

```php
FileUpload::make('banner')
    ->compressedWithSettings(
        maxWidth: 1200,  // Largura máxima em pixels
        quality: 90      // Qualidade de 1-100
    )
    ->label('Banner');
```

### Uso Direto do Componente

```php
use JuniorCastr\FilamentImageCompression\Components\CompressedFileUpload;

// Uso básico
CompressedFileUpload::make('image')
    ->label('Imagem');

// Para avatar
CompressedFileUpload::makeForAvatar('avatar')
    ->label('Avatar');

// Para múltiplas imagens
CompressedFileUpload::makeMultiple('gallery')
    ->label('Galeria');

// Com configurações personalizadas
CompressedFileUpload::makeWithSettings('banner', 1200, 90)
    ->label('Banner');
```

## Configurações Padrão

### Compressão Básica
- **Largura máxima**: 1920px
- **Qualidade**: 80%
- **Formato de saída**: WebP
- **Tamanho máximo**: 10MB

### Avatar
- **Largura máxima**: 400px
- **Qualidade**: 85%
- **Formato**: Circular com editor de imagem

### Formatos Suportados

**Entrada:**
- JPEG (.jpg, .jpeg)
- PNG (.png)
- GIF (.gif)
- WebP (.webp)
- BMP (.bmp)

**Saída:**
- WebP (formato otimizado)

## Exemplos de Uso em Resources

### Resource Básico

```php
<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Resource;

class PostResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                
                Forms\Components\FileUpload::make('featured_image')
                    ->compressed()
                    ->label('Imagem Destacada'),
                
                Forms\Components\FileUpload::make('gallery')
                    ->compressedMultiple()
                    ->label('Galeria de Imagens'),
            ]);
    }
}
```

### Resource com Configurações Personalizadas

```php
<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Resources\Resource;

class ProductResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                
                // Imagem principal com alta qualidade
                Forms\Components\FileUpload::make('main_image')
                    ->compressedWithSettings(1920, 95)
                    ->label('Imagem Principal'),
                
                // Thumbnails com menor qualidade
                Forms\Components\FileUpload::make('thumbnails')
                    ->compressedWithSettings(800, 70)
                    ->multiple()
                    ->label('Miniaturas'),
            ]);
    }
}
```

## Estrutura do Plugin

```
packages/filament-image-compression/
├── composer.json
├── README.md
└── src/
    ├── Components/
    │   └── CompressedFileUpload.php
    ├── Services/
    │   └── ImageCompressionService.php
    └── FilamentImageCompressionServiceProvider.php
```

## Macros Disponíveis

O plugin adiciona as seguintes macros ao componente `FileUpload`:

- `compressed()` - Upload básico com compressão
- `compressedAvatar()` - Upload de avatar circular
- `compressedMultiple()` - Upload múltiplo com compressão
- `compressedWithSettings(int $maxWidth, int $quality)` - Upload com configurações personalizadas

## Tratamento de Erros

O plugin possui tratamento robusto de erros:

- Se a compressão falhar, o arquivo original é mantido
- Logs detalhados são gerados para debugging
- Validação de tipos de arquivo antes da compressão

## Requisitos

- PHP 8.1+
- Laravel 10+
- Filament 4.x
- Intervention Image 3.x

## Licença

MIT License