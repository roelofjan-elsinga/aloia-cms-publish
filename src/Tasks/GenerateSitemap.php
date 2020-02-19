<?php

namespace AloiaCms\Publish\Tasks;

use Illuminate\Support\Facades\Artisan;

class GenerateSitemap implements TaskInterface
{
    public function run()
    {
        Artisan::call('aloiacms:publish:sitemap');
    }
}
