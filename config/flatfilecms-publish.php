<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Title
    |--------------------------------------------------------------------------
    |
    | This is the title used in the Atom Feed.
    |
    */

    'title' => env('FEED_TITLE', 'Atom feed'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Site URL
    |--------------------------------------------------------------------------
    |
    | This is the site URL used in the Atom Feed.
    |
    */

    'site_url' => env('SITE_URL', 'https://example.com'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Author
    |--------------------------------------------------------------------------
    |
    | This is the title used in the Atom Feed.
    |
    */

    'author' => env('SITE_AUTHOR', 'Author'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Title
    |--------------------------------------------------------------------------
    |
    | This is the title used in the Atom Feed.
    |
    */

    'feed_path' => env('FEED_URL', 'feed'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Title
    |--------------------------------------------------------------------------
    |
    | This is the title used in the Atom Feed.
    |
    */

    'feed_id' => env('FEED_IDENTIFIER', 'https://example.com/'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Atom feed file location
    |--------------------------------------------------------------------------
    |
    | This file path will be used to save the atom feed to an XML file
    |
    */

    'atom_file_path' => storage_path('app/atom.xml'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Sitemap file location
    |--------------------------------------------------------------------------
    |
    | This file path will be used to save the sitemap to an XML file
    |
    */

    'sitemap_file_path' => storage_path('app/sitemap.xml'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Sitemap target file path
    |--------------------------------------------------------------------------
    |
    | This target file path will be used to create a symlink for the original
    | version to the target location.
    |
    */

    'sitemap_target_file_path' => public_path('sitemap.xml'),

    /*
    |--------------------------------------------------------------------------
    | Flat File CMS Publish Article path
    |--------------------------------------------------------------------------
    |
    | This file path will be used to save the atom feed to an XML file
    |
    */

    'article_path' => env('ARTICLE_PATH', 'articles'),

];