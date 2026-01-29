# PHPStan HTML Output Formatter

Minimal, dark-themed HTML error report for PHPStan.

## Installation

```bash
composer require --dev ddr1nk/phpstan-html-output-formatter
```

## Usage

Generate HTML report:

```bash
vendor/bin/phpstan analyse --error-format=html > phpstan-report.html
```

You can also set it in your PHPStan config:

```neon
parameters:
    errorFormat: html
```

## Example

The output is a single HTML document with:
- summary cards (errors, files, warnings, internal errors)
- grouped file errors
- project-level errors, warnings, and internal errors

## License

MIT. See `LICENSE`.
