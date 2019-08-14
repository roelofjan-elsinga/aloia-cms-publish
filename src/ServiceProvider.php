<?php


namespace FlatFileCms\Publish;

use FlatFileCms\Publish\Console\AtomFeedGeneratorCommand;
use FlatFileCms\Publish\Console\PublishScheduledPosts;
use FlatFileCms\Publish\Console\SitemapCreator;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/flatfilecms-publish.php', 'flatfilecms-publish');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/flatfilecms-publish.php' => config_path('flatfilecms-publish.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                AtomFeedGeneratorCommand::class,
                PublishScheduledPosts::class,
                SitemapCreator::class
            ]);
        }
    }

}