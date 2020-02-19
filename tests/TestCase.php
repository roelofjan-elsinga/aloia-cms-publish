<?php

namespace AloiaCms\Tests;

use AloiaCms\Publish\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * @var  vfsStreamDirectory
     */
    protected $fs;

    public function setUp(): void
    {
        parent::setUp();

        $this->fs = vfsStream::setup('root', 0777, [
            'content' => [
                'collections' => [],
                'images' => [],
                'sitemap.xml' => '',
                'sitemap_prod.xml' => '',
                'atom.xml' => '',
                'rss.xml' => '',
            ],
        ]);

        $content_path = $this->fs->getChild('content')->url();

        Config::set('aloiacms-publish.site_url', "{$content_path}/images");
        Config::set('aloiacms-publish.atom_file_path', "{$content_path}/atom.xml");
        Config::set('aloiacms-publish.rss_file_path', "{$content_path}/rss.xml");
        Config::set('aloiacms-publish.sitemap_file_path', "{$content_path}/sitemap.xml");
        Config::set('aloiacms-publish.sitemap_target_file_path', "{$content_path}/sitemap_prod.xml");
        Config::set('aloiacms.collections_path', "{$content_path}/collections");

        File::copy('tests/assets/image.png', "{$content_path}/images/image.png");
    }

    protected function getAtomFeedContent(): string
    {
        return file_get_contents(
            Config::get('aloiacms-publish.atom_file_path')
        );
    }

    protected function getRssFeedContent(): string
    {
        return file_get_contents(
            Config::get('aloiacms-publish.rss_file_path')
        );
    }

    protected function getSitemapContent(): string
    {
        return file_get_contents(
            Config::get('aloiacms-publish.sitemap_file_path')
        );
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
