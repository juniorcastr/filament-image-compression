# Contributing to Filament Image Compression

Thank you for considering contributing to Filament Image Compression! We welcome contributions from the community and are grateful for any help you can provide.

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues to see if the problem has already been reported. When you are creating a bug report, please include as many details as possible:

- **Use a clear and descriptive title**
- **Describe the exact steps to reproduce the problem**
- **Provide specific examples to demonstrate the steps**
- **Describe the behavior you observed and what behavior you expected**
- **Include screenshots if applicable**
- **Provide your environment details** (PHP version, Laravel version, Filament version, etc.)

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

- **Use a clear and descriptive title**
- **Provide a step-by-step description of the suggested enhancement**
- **Provide specific examples to demonstrate the enhancement**
- **Describe the current behavior and explain the behavior you expected**
- **Explain why this enhancement would be useful**

### Pull Requests

1. **Fork the repository** and create your branch from `main`
2. **Install dependencies**: `composer install`
3. **Make your changes** following our coding standards
4. **Add tests** for any new functionality
5. **Run the test suite**: `composer test`
6. **Run code quality checks**: `composer analyse`
7. **Update documentation** if necessary
8. **Create a pull request** with a clear title and description

## Development Setup

### Prerequisites

- PHP 8.1 or higher
- Composer
- Laravel 10+ application for testing
- Filament 4+ installed

### Installation

1. Fork and clone the repository:
```bash
git clone https://github.com/your-username/filament-image-compression.git
cd filament-image-compression
```

2. Install dependencies:
```bash
composer install
```

3. Set up a test Laravel application or use an existing one:
```bash
# In your Laravel app
composer require --dev juniorcastr/filament-image-compression:@dev
```

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run specific test file
./vendor/bin/pest tests/Unit/ImageCompressionServiceTest.php
```

### Code Quality

We use several tools to maintain code quality:

```bash
# Run PHPStan analysis
composer analyse

# Fix code style
composer format

# Run all quality checks
composer quality
```

## Coding Standards

### PHP Standards

- Follow **PSR-12** coding standard
- Use **strict types** declaration in all PHP files
- Add **comprehensive docblocks** for all public methods
- Use **type hints** for all parameters and return types

### Code Style

```php
<?php

declare(strict_types=1);

namespace CondoSmart\FilamentImageCompression;

/**
 * Example class following our standards
 */
class ExampleClass
{
    /**
     * Example method with proper documentation
     */
    public function exampleMethod(string $parameter): bool
    {
        // Implementation
        return true;
    }
}
```

### Naming Conventions

- **Classes**: PascalCase (`ImageCompressionService`)
- **Methods**: camelCase (`compressImage`)
- **Variables**: camelCase (`$maxWidth`)
- **Constants**: SCREAMING_SNAKE_CASE (`MAX_FILE_SIZE`)

## Testing Guidelines

### Test Structure

- **Unit Tests**: Test individual classes and methods in isolation
- **Feature Tests**: Test complete workflows and integrations
- **Use Pest PHP** for all tests
- **Mock external dependencies** when appropriate

### Test Example

```php
<?php

use CondoSmart\FilamentImageCompression\Services\ImageCompressionService;

it('compresses images correctly', function () {
    $service = new ImageCompressionService();
    $file = UploadedFile::fake()->image('test.jpg', 2000, 1500);
    
    $result = $service->compressImage($file, 'public', 'test', 1920, 80);
    
    expect($result)->toBeString()
        ->and($result)->toEndWith('.webp');
});
```

## Documentation

### README Updates

When adding new features, please update the README.md with:
- Usage examples
- Configuration options
- Method documentation

### Code Documentation

- All public methods must have docblocks
- Include parameter and return type descriptions
- Add usage examples for complex methods
- Document any side effects or important behavior

## Commit Messages

Use clear and meaningful commit messages:

```
feat: add custom compression quality settings
fix: resolve memory leak in image processing
docs: update README with new examples
test: add unit tests for ImageCompressionService
refactor: improve error handling in CompressedFileUpload
```

### Commit Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `test`: Adding or updating tests
- `refactor`: Code refactoring
- `style`: Code style changes
- `perf`: Performance improvements
- `chore`: Maintenance tasks

## Release Process

1. **Update version** in `composer.json`
2. **Update CHANGELOG.md** with new features and fixes
3. **Create release tag**: `git tag v1.x.x`
4. **Push tag**: `git push origin v1.x.x`
5. **Create GitHub release** with release notes

## Getting Help

If you need help with contributing:

- **Check existing issues** and discussions
- **Create a new issue** with the "question" label
- **Join our community** discussions
- **Contact maintainers** directly if needed

## Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- GitHub contributors page

Thank you for contributing to Filament Image Compression! 🎉