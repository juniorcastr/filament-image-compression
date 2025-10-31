<?php

namespace CondoSmart\FilamentImageCompression\Components;

use CondoSmart\FilamentImageCompression\Services\ImageCompressionService;
use Filament\Forms\Components\FileUpload;
use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CompressedFileUpload extends FileUpload
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->saveUploadedFileUsing(function (TemporaryUploadedFile $file, callable $set) {
            $compressionService = app(ImageCompressionService::class);
            
            // Converte TemporaryUploadedFile para UploadedFile
            $uploadedFile = new UploadedFile(
                $file->getRealPath(),
                $file->getClientOriginalName(),
                $file->getMimeType(),
                null,
                true
            );
            
            // Verifica se é uma imagem antes de comprimir
            if (!$this->isImage($uploadedFile)) {
                // Se não for imagem, salva normalmente
                return $file->store($this->getDirectory(), $this->getDiskName());
            }
            
            // Comprime a imagem
            $compressedPath = $compressionService->compressImage(
                $uploadedFile,
                $this->getDiskName(),
                $this->getDirectory()
            );
            
            return $compressedPath;
        });
    }
    
    /**
     * Verifica se o arquivo é uma imagem
     */
    private function isImage(UploadedFile $file): bool
    {
        return str_starts_with($file->getMimeType() ?? '', 'image/');
    }
    
    /**
     * Cria uma instância do componente com compressão automática de imagens
     *
     * @param string|null $name
     * @return static
     */
    public static function make(?string $name = null): static
    {
        $static = parent::make($name);
        
        return $static
            ->acceptedFileTypes([
                'image/jpeg',
                'image/png', 
                'image/gif',
                'image/webp',
                'image/bmp'
            ])
            ->image()
            ->imageEditor()
            ->maxSize(10240) // 10MB máximo
            ->helperText('Imagens serão automaticamente convertidas para WebP e comprimidas (1920px máx, 80% qualidade).');
    }
    
    /**
     * Versão com configurações personalizadas
     *
     * @param string|null $name
     * @param int $maxWidth
     * @param int $quality
     * @return static
     */
    public static function makeWithSettings(?string $name = null, int $maxWidth = 1920, int $quality = 80): static
    {
        return static::make($name)
            ->helperText("Imagens serão automaticamente convertidas para WebP e comprimidas ({$maxWidth}px máx, {$quality}% qualidade).");
    }
    
    /**
     * Versão para avatares (menor resolução)
     *
     * @param string|null $name
     * @return static
     */
    public static function makeForAvatar(?string $name = null): static
    {
        return static::make($name)
            ->avatar()
            ->imageEditor()
            ->circleCropper()
            ->helperText('Avatar será automaticamente redimensionado e comprimido (400px máx, 85% qualidade).');
    }
    
    /**
     * Versão para múltiplas imagens
     *
     * @param string|null $name
     * @return static
     */
    public static function makeMultiple(?string $name = null): static
    {
        return static::make($name)
            ->multiple()
            ->reorderable()
            ->helperText('Todas as imagens serão automaticamente convertidas para WebP e comprimidas.');
    }
}