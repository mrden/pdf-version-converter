# PDF version converter 
PHP library for converting the version of PDF files (for compatibility purposes).

## Requirements

- PHP 7.3+
- Ghostscript (gs command on Linux)

## Installation

Run `php composer.phar require mrden/pdf-version-converter dev-master` or add the follow lines to composer and run `composer install`:

```
{
    "require": {
        "mrden/pdf-version-converter": "dev-master"
    }
}
```

## Usage

Guessing a version of PDF File:

```php
<?php

// import the composer autoloader
require_once __DIR__.'/vendor/autoload.php'; 

// import the namespaces
use Mrden\PDFVersionConverter\Guesser\RegexGuesser;
// [..]

$guesser = new RegexGuesser();
echo $guesser->guess('/path/to/my/file.pdf'); // will print something like '1.4'
```

Converting file to a new PDF version:

```php
<?php

// import the composer autoloader
require_once __DIR__.'/vendor/autoload.php'; 

// import the namespaces
use Symfony\Component\Filesystem\Filesystem,
    Mrden\PDFVersionConverter\Converter\GhostscriptConverterCommand,
    Mrden\PDFVersionConverter\Converter\GhostscriptConverter;

// [..]

$command = new GhostscriptConverterCommand();
$filesystem = new Filesystem();

$converter = new GhostscriptConverter($command, $filesystem);
$converter->convert('/path/to/my/file.pdf', '1.4');
```

## Contributing

Is really simple add new implementation of guesser or converter, just implement `GuessInterface` or `ConverterInterface`.

## Running unit tests

Run `phpunit -c tests`.
