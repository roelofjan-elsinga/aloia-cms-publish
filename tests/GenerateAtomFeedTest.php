<?php


namespace FlatFileCms\Tests;

use AloiaCms\Models\Article;

class GenerateAtomFeedTest extends \AloiaCms\Tests\TestCase
{
    public function testImageIsAddedToFeedIfExists()
    {
        Article::find('test-post')
            ->setMatter([
                'post_date' => date('Y-m-d'),
                'is_scheduled' => true
            ])
            ->setBody(file_get_contents('tests/assets/article-with-image.stub'))
            ->save();

        $this
            ->artisan('aloiacms:publish:posts')
            ->expectsOutput('Published posts for today');

        $this->assertTrue(Article::find('test-post')->isPublished());
        $this->assertStringContainsString('Testing', $this->getAtomFeedContent());
        $this->assertStringContainsString('Testing', $this->getRssFeedContent());
        $this->assertStringContainsString('test-post', $this->getSitemapContent());
    }
}
