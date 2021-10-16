<?php

namespace Aloefflerj\FedTheDog\Controller;

class UrlHandler implements UrlHandlerInterface
{
    use UrlHelper; 

    public function processUrl()
    {
        $url = $this->breakUrl();
        var_dump("the url is {$url}");
    }
}
