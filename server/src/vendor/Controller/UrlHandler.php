<?php

namespace Aloefflerj\FedTheDog\Controller;

class UrlHandler implements UrlHandlerInterface
{
    use UrlHelper; 

    public function processUrl()
    {
        $url = $this->breakUrl();

        return $url;
    }
}
