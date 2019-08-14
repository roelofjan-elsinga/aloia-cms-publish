<?php

namespace FlatFileCms\Publish\Console;

use FlatFileCms\Article;
use FlatFileCms\Publish\Tasks\GenerateFeed;
use FlatFileCms\Publish\Tasks\GenerateSitemap;
use FlatFileCms\Publish\Tasks\MarkPostsForTodayAsActive;
use Illuminate\Support\Collection;

class PublishScheduledPosts extends TaskCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flatfilecms:publish:posts {--date=}';

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
        GenerateSitemap::class
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = $this->getPosts();

        $post_for_today = $this->getPostForToday($posts);

        if (!is_null($post_for_today)) {
            foreach ($this->tasks() as $task) {
                $this->notifyTriggered($task);

                (new $task)->run();
            }

            $this->info('Published the post for today');
        } else {
            $this->info("No post scheduled for today");
        }
    }

    private function getPosts(): Collection
    {
        return Article::raw();
    }

    private function getPostForToday(Collection $posts): ?array
    {
        return collect($posts)
            ->filter(function ($post) {
                $date = $this->option('date') ?? date('Y-m-d');

                return $post['postDate'] === $date
                    && $post['isScheduled'] === true;
            })
            ->first();
    }
}
