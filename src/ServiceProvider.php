<?php


namespace AloiaCms\Publish;

use AloiaCms\Publish\Console\GenerateAtomFeed;
use AloiaCms\Publish\Console\PublishScheduledPosts;
use AloiaCms\Publish\Console\SitemapCreator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aloiacms-publish.php', 'aloiacms-publish');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/aloiacms-publish.php' => config_path('aloiacms-publish.php'),
        ], 'config');

        $this->commands([
            GenerateAtomFeed::class,
            PublishScheduledPosts::class,
            SitemapCreator::class
        ]);

        Collection::macro('keysToSnakeCase', function () {
            return $this->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value]);
        });
    }
}
