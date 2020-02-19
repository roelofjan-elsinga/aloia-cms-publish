<?php

namespace FlatFileCms\Tests;

use AloiaCms\Models\Page;

class SitemapCreatorTest extends \AloiaCms\Tests\TestCase
{
    public function testPageIsAddedToSitemap()
    {
        Page::find('test-page')
            ->setMatter([
                'title' => 'Test page',
                'description' => 'Test description',
                'post_date' => date('Y-m-d'),
                'is_published' => true,
                'is_scheduled' => false,
                'summary' => 'Test summary',
                'template_name' => 'default'
            ])
            ->setBody('# Testing')
            ->save();

        $this
            ->artisan('aloiacms:publish:sitemap')
            ->expectsOutput('Generated sitemap');

        $this->assertStringContainsString('test-page', $this->getSitemapContent());
    }
}
