<?php

namespace FlatFileCms\Publish\Tasks;

use Illuminate\Support\Facades\Config;
use Main\Tasks\TaskInterface;

class StageSitemapInGit implements TaskInterface
{

    /**
     * Run this task
     */
    public function run()
    {
        $sitemap_file_path = Config::get('flatfilecms-publish.sitemap_file_path');

        system("git add {$sitemap_file_path}");
    }
}
