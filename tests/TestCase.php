<?php

namespace FlatFileCms\Tests;

use FlatFileCms\FlatFileCmsServiceProvider;
use FlatFileCms\Publish\ServiceProvider;
use Illuminate\Support\Facades\Config;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * @var  vfsStreamDirectory
     */
    protected $fs;

    public function setUp(): void
    {
        parent::setUp();

        $this->fs = vfsStream::setup('root', 0777, [
            'content' => []
        ]);

        $content_path = $this->fs->getChild('content')->url();

        Config::set('flatfilecms-publish.atom_file_path', "{$content_path}/atom.xml");
    }

    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
