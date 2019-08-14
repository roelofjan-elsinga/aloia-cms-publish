# Flat File CMS Auto Publishing

This package is a publishing plugin for roelofjan-elsinga/flat-file-cms.

## Installation

You can include this package through Composer using:

```bash
composer require roelofjan-elsinga/flat-file-cms-publish
```

and if you want to customize the folder structure, then publish the configuration through:

```bash
php artisan vendor:publish --provider="FlatFileCms\\Publish\\ServiceProvider"
```

## Testing

You can run the included tests by running ``./vendor/bin/phpunit`` in your terminal.