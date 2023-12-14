<?php

namespace AloiaCms\Publish\Transformers;

use AtomFeedGenerator\FeedItem;
use AloiaCms\Contracts\ArticleInterface;

interface Transformer
{
    /**
     * Set the transformer source
     *
     * @param ArticleInterface $article
     * @return Transformer
     */
    public static function fromSource(ArticleInterface $article): Transformer;

    /**
     * Return the transformed source as a FeedItem
     *
     * @return FeedItem
     */
    public function toTarget(): FeedItem;
}
