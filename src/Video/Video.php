<?php

namespace Maxfactor\Support\Video;

use MediaEmbed\MediaEmbed;

class Video
{
    protected $embedder;

    public function __construct()
    {
        $this->embedder = new MediaEmbed();
    }

    /**
     * Get the embed code for almost any hosted video service simply by peroviding its URL
     *
     * @param string $url
     * @return string
     */
    public function embedCodeFor(string $url)
    {
        if (!$parsedUrl = $this->embedder->parseUrl($url)) {
            return null;
        }

        return $parsedUrl->getEmbedCode();
    }
}
