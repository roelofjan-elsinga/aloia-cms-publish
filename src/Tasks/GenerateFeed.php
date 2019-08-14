<?php


namespace FlatFileCms\Publish\Tasks;

use Illuminate\Support\Facades\Artisan;

class GenerateFeed implements TaskInterface
{
    public function run()
    {
        Artisan::call('flatfilecms:publish:feed');
    }
}
