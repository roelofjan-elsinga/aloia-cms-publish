<?php

namespace FlatFileCms\Publish\Tasks;

use Illuminate\Support\Facades\Config;
use Main\Tasks\TaskInterface;

class StageArticleMetaDataInGit implements TaskInterface
{

    /**
     * Run this task
     */
    public function run()
    {
        $file_path = Config::get('flatfilecms.articles.file_path');

        system("git add {$file_path}");
    }
}
