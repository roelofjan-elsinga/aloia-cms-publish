<?php


namespace FlatFileCms\Publish\Tasks;

use Carbon\Carbon;
use FlatFileCms\Article;
use Illuminate\Support\Collection;

class MarkPostsForTodayAsActive implements TaskInterface
{

    /**
     * Run this task
     */
    public function run()
    {
        $posts = $this->getPosts()
            ->map(function ($post) {
                $postDate = Carbon::createFromFormat('Y-m-d', $post['postDate']);

                $post['isPublished'] = $post['isPublished'] || Carbon::now()->greaterThanOrEqualTo($postDate) && $post['isScheduled'];
                $post['isScheduled'] = $post['isPublished'] ? false : $post['isScheduled'];

                return $post;
            });

        $this->writeToFile($posts);
    }

    /**
     * Get the posts from the meta data file
     *
     * @return array
     */
    private function getPosts(): Collection
    {
        return Article::raw();
    }

    /**
     * Write changes to the post in the meta data file
     *
     * @param array $posts
     */
    private function writeToFile(Collection $posts): void
    {
        Article::update($posts);
    }
}
