<?php

namespace FlatFileCms\Publish\Tasks;

use Carbon\Carbon;
use Main\Tasks\TaskInterface;

class CommitChangesToGit implements TaskInterface
{
    protected $message_prefix = 'Adding blog posts for';

    /**
     * Run this task
     */
    public function run()
    {
        $date = Carbon::now()->toDateString();

        system("git commit -m '{$this->message_prefix} {$date}'");
    }
}
