<?php

namespace FlatFileCms\Publish\Console;

use AtomFeedGenerator\AtomFeedGenerator;
use FlatFileCms\Publish\AtomFeedConfiguration;
use FlatFileCms\Publish\Transformers\ArticleFeedItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use FlatFileCms\Article;

class AtomFeedGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flatfilecms:publish:feed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an Atom feed for the website';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Generating Atom feed for articles...");

        $articles = Article::published()

            ->filter(function (Article $article) {

                return empty($article->url());

            })

            ->map(function (Article $article) {

                return ArticleFeedItem::forArticle($article);

            });

        $configuration = new AtomFeedConfiguration();

        $generator = AtomFeedGenerator::withConfiguration($configuration);

        $articles->each(function(ArticleFeedItem $item) use ($generator) {

            $generator->add($item);

        });

        $atom_string = $generator->generate();

        file_put_contents(Config::get('flatfilecms-publish.atom_file_path'), $atom_string);

        $this->info("Generated Atom feed");
    }
}
