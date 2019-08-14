<?php

namespace FlatFileCms\Publish\Console;

use Carbon\Carbon;
use FlatFileCms\Page;
use FlatFileCms\Publish\Transformers\ArticleFeedItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use FlatFileCms\Article;
use SitemapGenerator\SitemapGenerator;

class SitemapCreator extends Command
{

    /**@var string*/
    private $domain;

    /**@var string*/
    private $lastmod;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flatfilecms:publish:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a sitemap for the website';

    /**
     * SitemapCreator constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->domain = Cache::get('flatfilecms-publish.site_url');
        $this->lastmod = Carbon::now()->toDateString();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $generator = SitemapGenerator::boot($this->domain);

        $urls = [
            '/' => 1,
            '/articles' => 0.9
        ];

        foreach ($urls as $url => $priority) {
            $generator->add($url, $priority, $this->lastmod, 'monthly');
        }

        foreach (Page::published() as $page) {
            $generator->add($page->slug(), 0.9, $this->lastmod, 'monthly');
        }

        $article_urls = $this->getArticleUrls();

        foreach ($article_urls as $url) {
            $generator->add($url, 0.7, $this->lastmod, 'monthly');
        }

        $this->persistUrlsToSitemap($generator->toXML());

        $this->createSymlinkForSitemap();

        $this->info("Generated sitemap");
    }

    /**
     * Get the urls of the articles
     *
     * @param string $path
     * @return array
     */
    private function getArticleUrls(): array
    {
        return Article::published()
            ->map(function (Article $article) {
                return ArticleFeedItem::forArticle($article)->url();
            })
            ->toArray();
    }

    /**
     * Write the data to file
     *
     * @param string $sitemap
     */
    private function persistUrlsToSitemap(string $sitemap)
    {
        $filename = "sitemap.xml";

        Storage::delete($filename);

        Storage::put($filename, $sitemap);
    }

    private function createSymlinkForSitemap()
    {
        if (!File::exists(public_path('sitemap.xml'))) {
            File::link(storage_path('app/sitemap.xml'), public_path('sitemap.xml'));
        }
    }
}
