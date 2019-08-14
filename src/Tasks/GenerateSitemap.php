<?php

namespace FlatFileCms\Publish\Tasks;

use Illuminate\Support\Facades\Artisan;

class GenerateSitemap implements TaskInterface
{
    public function run()
    {
        Artisan::call('flatfilecms:publish:sitemap');
    }
}
