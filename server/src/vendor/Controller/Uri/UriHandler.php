<?php

namespace Aloefflerj\FedTheDog\Controller\Uri;

use Aloefflerj\FedTheDog\Controller\Psr\Http\Message\UriInterface;
use Aloefflerj\FedTheDog\Controller\UrlHelper;

class UriHandler
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
        $this->path = $this->getUrlPath();

        return $this->path;
    }

}