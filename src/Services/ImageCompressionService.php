<?php

namespace CondoSmart\FilamentImageCompression\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageCompressionService
{
    private ImageManager $manager;
    
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }
    
    /**
     * Comprime e converte imagem para WebP
     */
    public function compressImage(UploadedFile $file, string $disk = 'public', string $path = ''): string
    {
        // Verifica se é uma imagem
        if (!$this->isImage($file)) {
            throw new \InvalidArgumentException('Arquivo não é uma imagem válida.');
        }
        
        // Carrega a imagem
        $image = $this->manager->read($file->getPathname());
        
        // Redimensiona mantendo proporção (máx 1920px de largura)
        if ($image->width() > 1920) {
            $image->scaleDown(width: 1920);
        }
        
        // Gera nome único para o arquivo WebP
        $filename = Str::uuid() . '.webp';
        $fullPath = $path ? $path . '/' . $filename : $filename;
        
        // Converte para WebP com 80% de qualidade
        $webpData = $image->toWebp(80);
        
        // Salva no storage
        Storage::disk($disk)->put($fullPath, $webpData);
        
        return $fullPath;
    }
    
    /**
     * Verifica se o arquivo é uma imagem
     */
    private function isImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
        return in_array($file->getMimeType(), $allowedMimes);
    }
    
    /**
     * Obtém informações da imagem comprimida
     */
    public function getImageInfo(string $path, string $disk = 'public'): array
    {
        if (!Storage::disk($disk)->exists($path)) {
            throw new \InvalidArgumentException('Arquivo não encontrado.');
        }
        
        $fullPath = Storage::disk($disk)->path($path);
        $image = $this->manager->read($fullPath);
        
        return [
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => Storage::disk($disk)->size($path),
            'mime_type' => 'image/webp'
        ];
    }
}