<?php

namespace Aloefflerj\FedTheDog\Controller;

use Aloefflerj\FedTheDog\Controller\Helpers\StringHelper;
use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;

class BaseController
// class BaseController implements ControllerInterface
{
    use StringHelper;
    /**
     * Group all routes
     *
     * @var array $routes
     */
    public array $routes;

    /**
     * Group random data
     *
     * @var array $data
     */
    private array $data;


    /**
     * To deal with the url
     *
     * @var UrlHandler $urlHandler
     */
    private UrlHandler $urlHandler;

    /**
     * Errors
     *
     * @var \Exception $error
     */
    private \Exception $error;

    public function __construct()
    {
        $this->urlHandler = new UrlHandler();
        $this->routes = [];
    }

    /**
     * Get http verb route add
     *
     * @param string $uri
     * @param \closure $output
     * @param array|null $params
     * @return BaseController
     */
    public function get(string $uri, \closure $output, ?array $params = null): BaseController
    {
        $this->addRoute($uri, $output, $params);
        return $this;
    }

    public function post($body)
    {
        echo "<pre>", var_dump($body), "</pre>";
    }

    public function put($body)
    {
        echo "<pre>", var_dump($body), "</pre>";
    }

    /**
     * Dispatch all the added routes
     *
     * @return BaseController
     */
    public function dispatch()
    {
        $currentUri = $this->urlHandler->getUriPath();

        /**
         * 
         */
        
        if (!array_key_exists($currentUri, $this->routes)) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }

        $currentRoute = $this->routes[$currentUri];

        $routeName = $currentRoute->name;
        $routeParams = $this->splitHeaderParams($routeName);

        $callBack = $currentRoute->output;

        $params = $currentRoute->params;

        $paramsFormatted = (object) $params;
        $callBack($paramsFormatted, '');

        return $this;
    }

    /**
     * Error handling
     *
     * @return \Exception|null
     */
    public function error(): ?\Exception
    {
        return $this->error ?? null;
    }

    /**
     * ||================================================================||
     *                          HELPER FUNCTIONS
     * ||================================================================||
     * 
     * refactor => transform into traits
     */

    /**
     * Add route helper
     *
     * @param string $uri
     * @param \closure $output
     * @param array|null $params
     * @return array|null
     */
    private function addRoute(string $uri, \closure $output, ?array $params): ?BaseController
    {
        if(strpos($uri, '{') !== false) {
            // $headerParamsQty = substr_count($uri, "{");
            $headerParams = explode('{', $uri);
            $headerParams = str_replace(['}', '/'], '', $headerParams);
            array_shift($headerParams);
        }

        if (!in_array($uri, $this->routes)) {
            $route = new \stdClass();

            $route->name            = $uri;
            $route->output          = $output;
            $route->headerParams    = $headerParams;
            $route->params          = $params;
            // $route->headersParamQty = $headerParamsQty ?? null;

            $this->routes[$uri] = $route;
        }

        return $this->routes[$uri] ? $this : null;
    }

    /**
     * getRoutes
     *
     * @return array|null
     */
    public function getRoutes(): ?array
    {
        return $this->routes ?? null;
    }

    private function splitHeaderParams($uri)
    {
        // echo "<pre>" . var_dump($uri) . "</pre>";
    }
}
