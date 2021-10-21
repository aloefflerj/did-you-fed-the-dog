<?php

namespace Aloefflerj\FedTheDog\Controller\Url;

use Aloefflerj\FedTheDog\Controller\Helpers\StringHelper;
use Aloefflerj\FedTheDog\Controller\Helpers\UrlHelper;
use stdClass;

class UrlHandler
// class UriHandler implements UriInterface
{
    use UrlHelper;
    use StringHelper;
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

    /**
     * ||================================================================||
     *                          HELPER FUNCTIONS
     * ||================================================================||
     * 
     * refactor => transform into traits
     */

    public function routeWithHeaderParams($currentUri, $routes)
    {
        foreach($routes as $route) {
            // echo $route->name . "<br>";
            $mappedRoute['same'][] = $this->stringCompare($currentUri, $route->name);
            $mappedRoute['name'][] = $route->name;
        }

        $longest = '';
        $routeName = '';

        foreach($mappedRoute['same'] as $key => $routeChunk) {
            if(empty($longest) || $routeChunk > $longest) {
                $longest = $routeChunk;
                $routeName = $mappedRoute['name'][$key];
            }
        }

        return $routeName;
        // echo "<pre>" . var_dump($same) . "</pre>";
    }
}
