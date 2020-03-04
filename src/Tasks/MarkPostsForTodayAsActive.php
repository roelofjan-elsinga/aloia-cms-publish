<?php


namespace AloiaCms\Publish\Tasks;

use Carbon\Carbon;
use AloiaCms\Models\Article;

class MarkPostsForTodayAsActive implements TaskInterface
{

    /**
     * Run this task
     */
    public function run()
    {
        Article::all()
            ->each(function (Article $post) {
                $is_published = $post->isPublished() || (Carbon::now()->greaterThanOrEqualTo($post->getPostDate()) && $post->isScheduled());
                $is_scheduled = $is_published ? false : $post->isScheduled();

                $post
                    ->addMatter('is_published', $is_published)
                    ->addMatter('is_scheduled', $is_scheduled)
                    ->save();
            });
    }
}
