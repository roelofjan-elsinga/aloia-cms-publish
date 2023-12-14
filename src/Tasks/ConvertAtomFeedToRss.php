<?php


namespace AloiaCms\Publish\Tasks;

use DOMDocument;
use Illuminate\Support\Facades\Config;
use XSLTProcessor;

class ConvertAtomFeedToRss implements TaskInterface
{
    /**
     * Run this task
     *
     * @return void
     */
    public function run()
    {
        $chan = new DOMDocument();
        $chan->load(Config::get('aloiacms-publish.atom_file_path'));

        $sheet = new DOMDocument();
        $stylesheet_path = __DIR__ . '../../../resources/atom2rss.xsl';
        $sheet->load($stylesheet_path);

        $processor = new XSLTProcessor();
        $processor->registerPHPFunctions();
        $processor->importStylesheet($sheet);

        file_put_contents(
            Config::get('aloiacms-publish.rss_file_path'),
            $processor->transformToXML($chan)
        );
    }
}
