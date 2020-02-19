<?php

namespace FlatFileCms\Tests;

use AloiaCms\Models\Article;

class PublishScheduledPostsTest extends \AloiaCms\Tests\TestCase
{
    public function testScheduledPostsCanBePublished()
    {
        Article::find('test-post')
            ->setMatter([
                'post_date' => date('Y-m-d'),
                'is_scheduled' => true
            ])
            ->setBody('# Testing')
            ->save();

        $this
            ->artisan('aloiacms:publish:posts')
            ->expectsOutput('Published posts for today');

        file_put_contents('atom.xml', $this->getAtomFeedContent());

        $this->assertTrue(Article::find('test-post')->isPublished());
        $this->assertStringContainsString('Testing', $this->getAtomFeedContent());
        $this->assertStringContainsString('Testing', $this->getRssFeedContent());
        $this->assertStringContainsString('test-post', $this->getSitemapContent());
    }

    public function testNoPostsArePublishedIfNoneAreScheduled()
    {
        Article::find('test-post')
            ->setMatter([
                'post_date' => date('Y-m-d'),
                'is_scheduled' => false
            ])
            ->setBody('# Testing')
            ->save();

        $this
            ->artisan('aloiacms:publish:posts')
            ->expectsOutput('No post scheduled for today');

        $this->assertFalse(Article::find('test-post')->isPublished());
        $this->assertStringNotContainsString('Testing', $this->getAtomFeedContent());
        $this->assertStringNotContainsString('Testing', $this->getRssFeedContent());
        $this->assertStringNotContainsString('test-post', $this->getSitemapContent());
    }
}
