# Flat File CMS Publishing module

<a href="https://travis-ci.com/roelofjan-elsinga/flat-file-cms-publish"><img src="https://travis-ci.com/roelofjan-elsinga/flat-file-cms-publish.svg" alt="Build Status"></a>
<img src="https://github.styleci.io/repos/202364633/shield" alt="StyleCI Status">
<a href="https://packagist.org/packages/roelofjan-elsinga/flat-file-cms-publish"><img src="https://poser.pugx.org/roelofjan-elsinga/flat-file-cms-publish/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/roelofjan-elsinga/flat-file-cms-publish"><img src="https://poser.pugx.org/roelofjan-elsinga/flat-file-cms-publish/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/roelofjan-elsinga/flat-file-cms-publish"><img src="https://poser.pugx.org/roelofjan-elsinga/flat-file-cms-publish/license" alt="License"></a>

This is a self publishing module for [Flat File CMS](https://github.com/roelofjan-elsinga/flat-file-cms).

## Installation

You can include this package through Composer using:

```bash
composer require roelofjan-elsinga/flat-file-cms-publish
```

and if you want to customize the folder structure, then publish the configuration through:

```bash
php artisan vendor:publish --provider="FlatFileCms\\Publish\\ServiceProvider"
```

## Overwriting the sitemap command

You can overwrite the sitemap command, as this only adds support for articles and 
pages by default. To do this, you'll need to make your own implementation of the 
command and register this in a service provider like so:

```php
namespace App\Console\Commands;

use SitemapGenerator\SitemapGenerator;

class SitemapCreator extends \FlatFileCms\Publish\Console\SitemapCreator
{

    /**
     * Overwrite the base implementation and add additional URL's
     *
     * @param SitemapGenerator $generator
     */
    protected function appendAdditionalUrls(SitemapGenerator $generator): void
    {
        foreach($this->getArrayOfOtherUrlsToAdd() as $url) {
            $generator->add($url, 0.8, $this->lastmod, 'monthly');
        }
    }

    /**
     * Get the urls of the portfolio items
     *
     * @return array
     */
    private function getArrayOfOtherUrlsToAdd(): array
    {
        return [
            '/contact',
            '/services',
            '/any-other-urls-you-wish'
        ];
    }

}
```

and register this new command in the AppServiceProvider:

```php
public function register()
{
    $this->app->bind(\FlatFileCms\Publish\Console\SitemapCreator::class, function () {
        return new \App\Console\Commands\SitemapCreator();
    });
}
```

You can now add any custom urls to the sitemap.

## Testing

You can run the included tests by running ``./vendor/bin/phpunit`` in your terminal.
