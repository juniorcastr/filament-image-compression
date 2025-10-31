# Changelog

All notable changes to `filament-image-compression` will be documented in this file.

## [Unreleased]

### Added
- Initial release of Filament Image Compression plugin
- Automatic image compression and WebP conversion
- Multiple component factory methods (`make`, `makeWithSettings`, `makeForAvatar`, `makeMultiple`)
- Filament FileUpload macros (`compressed`, `compressedAvatar`, `compressedMultiple`, `compressedWithSettings`)
- Configurable compression settings (quality, max width)
- Support for JPEG, PNG, GIF, BMP, and WebP input formats
- Comprehensive configuration file
- Image compression analytics and ratio calculation
- Memory management and performance optimizations

### Features
- **CompressedFileUpload Component**: Drop-in replacement for Filament's FileUpload
- **ImageCompressionService**: Core service for image processing
- **Flexible Configuration**: Global and per-component settings
- **WebP Conversion**: Automatic conversion to modern WebP format
- **Quality Control**: Configurable compression quality (1-100%)
- **Size Optimization**: Automatic resizing with aspect ratio preservation
- **Multiple Upload Support**: Optimized handling for multiple file uploads
- **Avatar Optimization**: Special settings for profile pictures

### Technical Details
- Uses Intervention Image library for reliable image processing
- Maintains aspect ratios during resizing
- Generates unique filenames to prevent conflicts
- Supports Laravel's storage system with configurable disks
- Comprehensive error handling and validation

### Requirements
- PHP 8.1 or higher
- Laravel 10.0 or higher
- Filament 4.0 or higher
- GD or Imagick PHP extension
- Intervention Image 3.0 or higher

## [1.0.0] - 2024-01-XX

### Added
- Initial stable release
- Complete documentation and examples
- Test suite with Pest PHP
- GitHub Actions CI/CD pipeline
- Comprehensive README with usage examples

---

## Release Notes Format

This project follows [Semantic Versioning](https://semver.org/).

### Types of Changes
- **Added** for new features
- **Changed** for changes in existing functionality
- **Deprecated** for soon-to-be removed features
- **Removed** for now removed features
- **Fixed** for any bug fixes
- **Security** in case of vulnerabilities