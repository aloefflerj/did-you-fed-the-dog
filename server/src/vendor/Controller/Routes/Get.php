<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;

class Get extends Route
{
    public function __construct(string $uri, \closure $output, ?array $functionParams)
    {
        parent::__construct($uri, $output, $functionParams);

        $this->verb         =  parent::getVerbName(__CLASS__);
        $this->verbParams   = $this->splitToParams($uri);

        $this->urlHandler   = new UrlHandler();
    }

    /**
     * Split uri params into array
     *
     * @param string $uri
     * @return array|null
     */
    private function splitToParams(string $uri): ?array
    {
        if (strpos($uri, '{') !== false) {
            $headerParams = explode('{', $uri);
            $headerParams = str_replace(['}', '/'], '', $headerParams);
            array_shift($headerParams);
        }

        return $headerParams ?? null;
    }

    public static function getRoute($currentUri, $routes, $currentRequestMethod)
    {
        $currentRoute = self::$urlHandler->routeWithUrlParams($currentUri, $routes[$currentRequestMethod]);

        if (!$routes[$currentRequestMethod][$currentRoute]->verbParams) {
            $currentRoute = $currentUri;
        }

        return $currentRoute;
    }

    public function dispatch()
    {
        $uri = self::$urlHandler->getUriPath();
        
        //Get the route params
        $callBackParams = $this->getParams($uri);

        if ($callBackParams === null) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }

        // Get the output function
        $output = $this->output;
        $output($callBackParams, '');

        return $this;
    }

    private function getParams($currentUri, ?bool $overwriteArrayParams = false)
    {
        $urlParams = $this->verbParams;
        $params = $this->functionParams;

        if ($urlParams && !$params && !$overwriteArrayParams) {

            $urlParamsQty = count($urlParams);

            if (substr_count($currentUri, "/") - 1 !== $urlParamsQty) {
                return null;
            }

            $urlParamsArray = explode("/", $currentUri);
            $params = array_slice($urlParamsArray, -$urlParamsQty);

            $params = array_combine($urlParams, $params);
        }

        return (object)$params;
    }
}
