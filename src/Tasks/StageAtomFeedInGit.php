<?php

namespace FlatFileCms\Publish\Tasks;

use Illuminate\Support\Facades\Config;
use Main\Tasks\TaskInterface;

class StageAtomFeedInGit implements TaskInterface
{

    /**
     * Run this task
     */
    public function run()
    {
        $atom_file_path = Config::get('flatfilecms-publish.atom_file_path');

        system("git add {$atom_file_path}");
    }
}
