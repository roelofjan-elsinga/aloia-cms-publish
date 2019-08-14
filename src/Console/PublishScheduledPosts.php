<?php

namespace FlatFileCms\Publish\Console;

use FlatFileCms\Article;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Main\Tasks\Deploy\MarkDeploymentAsInactive;
use Main\Tasks\Deploy\PushLocalToRemote;
use Main\Tasks\Publish\CommitChangesToGit;
use Main\Tasks\Publish\GenerateFeed;
use Main\Tasks\Publish\GenerateSitemap;
use Main\Tasks\Publish\MarkPostsForTodayAsActive;
use Main\Tasks\Publish\StageArticleMetaDataInGit;
use Main\Tasks\Publish\StageAtomFeedInGit;
use Main\Tasks\Publish\StageSitemapInGit;

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
        GenerateSitemap::class,
        StageAtomFeedInGit::class,
        StageSitemapInGit::class,
        StageArticleMetaDataInGit::class,
        CommitChangesToGit::class,
        MarkDeploymentAsInactive::class,
        PushLocalToRemote::class
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
