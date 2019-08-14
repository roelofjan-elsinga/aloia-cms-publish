<?php

namespace FlatFileCms\Publish\Console;

use Illuminate\Console\Command;

abstract class TaskCommand extends Command
{
    /**
     * The tasks to perform in this command
     *
     * @var array
     */
    protected $tasks = [];

    /**
     * Get the tasks to perform for this command
     *
     * @return array
     */
    protected function tasks(): array
    {
        return $this->tasks;
    }

    /**
     * Get the message to display with a task is triggered
     *
     * @param string $task_name
     * @return string
     */
    protected function notifyTriggered(string $task_name)
    {
        $this->info("Run task: {$task_name}");
    }
}
