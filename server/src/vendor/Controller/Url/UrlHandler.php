<?php

namespace Aloefflerj\FedTheDog\Controller\Url;

use Aloefflerj\FedTheDog\Controller\Helpers\UrlHelper;

class UrlHandler
// class UriHandler implements UriInterface
{
    use UrlHelper;
    /**
     * Undocumented variable
     *
     * @var string
     */
    public string $url;

    // public function __construct(string $url) {
    //     /** @var string */
    //     $this->url = $url;
    // }

    public function getPath()
    {
        $this->path = $this->getUriPath();

        return $this->path;
    }

}