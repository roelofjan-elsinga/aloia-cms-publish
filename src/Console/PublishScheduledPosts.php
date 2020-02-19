<?php

namespace AloiaCms\Publish\Console;

use AloiaCms\Models\Article;
use AloiaCms\Publish\Tasks\ConvertAtomFeedToRss;
use AloiaCms\Publish\Tasks\GenerateFeed;
use AloiaCms\Publish\Tasks\GenerateSitemap;
use AloiaCms\Publish\Tasks\MarkPostsForTodayAsActive;

class PublishScheduledPosts extends TaskCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aloiacms:publish:posts {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish any posts that need to be published at this time';

    /**
     * The tasks to perform in this command
     *
     * @var array
     */
    protected $tasks = [
        MarkPostsForTodayAsActive::class,
        GenerateFeed::class,
        ConvertAtomFeedToRss::class,
        GenerateSitemap::class
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $post_for_today = $this->getPostForToday();

        if (!is_null($post_for_today)) {
            foreach ($this->tasks() as $task) {
                $this->notifyTriggered($task);

                (new $task)->run();
            }

            $this->info('Published posts for today');
        } else {
            $this->info("No post scheduled for today");
        }
    }

    private function getPostForToday(): ?Article
    {
        return Article::all()
            ->filter(function (Article $post) {
                $date = $this->option('date') ?? date('Y-m-d');

                return $post->getPostDate()->toDateString() === $date && $post->isScheduled();
            })
            ->first();
    }
}
