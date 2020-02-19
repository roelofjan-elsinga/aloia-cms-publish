<?php


namespace AloiaCms\Publish\Tasks;

use Illuminate\Support\Facades\Artisan;

class GenerateFeed implements TaskInterface
{
    public function run()
    {
        Artisan::call('aloiacms:publish:feed');
    }
}
