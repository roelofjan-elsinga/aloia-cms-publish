<?php


namespace FlatFileCms\Publish;


use AtomFeedGenerator\FeedConfiguration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class AtomFeedConfiguration implements FeedConfiguration
{
    /**
     * The title of the Atom Feed
     *
     * @return string
     */
    public function title(): string
    {
        return Config::get('flatfilecms-publish.title');
    }

    /**
     * The URL of the website for which this Atom Feed is generated
     *
     * @return string
     */
    public function siteUrl(): string
    {
        return Config::get('flatfilecms-publish.site_url');
    }

    /**
     * The URL at which this feed can be accessed
     *
     * @return string
     */
    public function feedUrl(): string
    {
        $feed_path = Config::get('flatfilecms-publish.feed_path');

        $feed_prefix = $feed_path[0] === '/' ? '' : '/';

        return $this->siteUrl() . $feed_prefix . $feed_path;
    }

    /**
     * The date at which this Atom feed is last modified
     *
     * @return Carbon
     */
    public function lastModified(): Carbon
    {
        return Carbon::now();
    }

    /**
     * The author of the Atom feed
     *
     * @return string
     */
    public function author(): string
    {
        return Config::get('flatfilecms-publish.author');
    }

    /**
     * The identifier for this Atom feed
     *
     * @return string
     */
    public function identifier(): string
    {
        return Config::get('flatfilecms-publish.feed_id');
    }
}