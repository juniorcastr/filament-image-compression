# Security Policy

## Supported Versions

We actively support the following versions of Filament Image Compression:

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Reporting a Vulnerability

We take security vulnerabilities seriously. If you discover a security vulnerability within Filament Image Compression, please send an email to **juniorcastrz@gmail.com**. All security vulnerabilities will be promptly addressed.

### What to Include

When reporting a vulnerability, please include:

- A clear description of the vulnerability
- Steps to reproduce the issue
- Potential impact of the vulnerability
- Any suggested fixes or mitigations

### Response Timeline

- **Initial Response**: Within 48 hours
- **Status Update**: Within 7 days
- **Resolution**: Varies based on complexity, but we aim for quick fixes

### Disclosure Policy

- Please do not publicly disclose the vulnerability until we have had a chance to address it
- We will acknowledge your contribution in the security advisory (unless you prefer to remain anonymous)
- We will provide credit in our changelog and release notes

## Security Considerations

### File Upload Security

This plugin processes uploaded files and converts them to different formats. Please ensure:

1. **File Validation**: Always validate file types and sizes before processing
2. **Storage Security**: Use secure storage configurations and proper file permissions
3. **Memory Limits**: Configure appropriate memory limits for image processing
4. **Input Sanitization**: The plugin sanitizes file names and validates MIME types

### Best Practices

When using this plugin:

1. **Validate File Types**: Use Filament's built-in validation rules
2. **Limit File Sizes**: Set appropriate maximum file sizes
3. **Secure Storage**: Use private storage disks when appropriate
4. **Monitor Resources**: Keep an eye on server resources during image processing

### Dependencies

This plugin relies on:

- **Intervention Image**: For image processing and manipulation
- **Laravel Storage**: For file handling
- **Filament**: For UI components

We regularly update dependencies to address security vulnerabilities.

## Contact

For security-related questions or concerns:

- **Email**: juniorcastrz@gmail.com
- **GitHub**: Create a private security advisory on our repository

Thank you for helping keep Filament Image Compression secure!