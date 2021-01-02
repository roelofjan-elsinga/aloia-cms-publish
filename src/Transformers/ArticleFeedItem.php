<?php


namespace AloiaCms\Publish\Transformers;

use AloiaCms\Models\Article;
use AtomFeedGenerator\FeedItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ArticleFeedItem implements FeedItem
{
    /**
     * @var Article
     */
    private $article;

    /**
     * ArticleFeedItem constructor.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Named constructor.
     *
     * @param Article $article
     * @return ArticleFeedItem
     */
    public static function forArticle(Article $article): ArticleFeedItem
    {
        return new static($article);
    }

    /**
     * Get the title of the feed item
     *
     * @return string
     * @throws \Exception
     */
    public function title(): string
    {
        return $this->article->title();
    }

    /**
     * Get the accessible url of the feed item
     *
     * @return string
     */
    public function url(): string
    {
        $article_path = Config::get('aloiacms-publish.article_path');

        $article_path = $article_path[0] === '/' ? substr($article_path, 1) : $article_path;

        $article_path_suffix = $article_path[strlen($article_path) - 1] === '/' ? '' : '/';

        return $article_path . $article_path_suffix . $this->article->slug();
    }

    /**
     * Get the content of the feed item
     *
     * @return string
     * @throws \Exception
     */
    public function content(): string
    {
        return $this->article->body();
    }

    /**
     * Get the summary of the feed item
     *
     * @return string
     * @throws \Exception
     */
    public function summary(): string
    {
        return $this->article->description();
    }

    /**
     * Determine whether this feed item has an image
     *
     * @return bool
     * @throws \Exception
     */
    public function hasImage(): bool
    {
        return !empty($this->article->image());
    }

    /**
     * Get the URL of the image of the feed item
     *
     * @return string
     * @throws \Exception
     */
    public function imageUrl(): string
    {
        $domain = Config::get('aloiacms-publish.site_url');

        $image_url = $this->article->image();

        // Return URL if external image
        if (!is_null(parse_url($image_url, PHP_URL_HOST))) {
            return $image_url;
        }

        $image_prefix = $image_url[0] === '/' ? '' : '/';

        return $domain . $image_prefix . $image_url;
    }

    /**
     * Get the path of the article image, return absolute path if it's not an external URL
     *
     * @return string
     * @throws \Exception
     */
    private function imagePath(): string
    {
        $image_url = $this->article->image();

        if (!is_null(parse_url($image_url, PHP_URL_HOST))) {
            return $image_url;
        } else {
            $image_prefix = $image_url[0] === '/' ? '' : '/';

            return public_path($image_prefix . $image_url);
        }
    }

    /**
     * Get the mime type of the image of the feed item
     *
     * @return string
     * @throws \Exception
     */
    public function imageMimeType(): string
    {
        $image_size = getimagesize($this->imagePath());

        return $image_size['mime'];
    }

    /**
     * Get the width of the image of the feed item
     *
     * @return int
     * @throws \Exception
     */
    public function imageWidth(): int
    {
        $image_size = getimagesize($this->imagePath());

        return $image_size[0];
    }

    /**
     * Get the height of the image of the feed item
     *
     * @return int
     * @throws \Exception
     */
    public function imageHeight(): int
    {
        $image_size = getimagesize($this->imagePath());

        return $image_size[1];
    }

    /**
     * Get the date on which the feed item was created
     *
     * @return Carbon
     */
    public function createdAt(): Carbon
    {
        return $this->article->getPostDate()->setTimeFromTimeString("12:00:00");
    }

    /**
     * Get the date on which the feed item was last updated
     *
     * @return Carbon
     */
    public function updatedAt(): Carbon
    {
        return $this->article->getUpdateDate() ?? $this->createdAt();
    }

    /**
     * Determine whether the input is a valid URL
     *
     * @param $value
     * @return bool
     */
    private function isUrl($value): bool
    {
        if (! is_string($value)) {
            return false;
        }

        if ($url = parse_url($value, PHP_URL_HOST)) {
            try {
                return count(dns_get_record($url, DNS_A | DNS_AAAA)) > 0;
            } catch (\Exception $e) {
                return false;
            }
        }

        return false;
    }
}
