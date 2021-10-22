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

        $currentRoute = $this->getCurrentRoute();

        // Check if it is mapped
        if (!$this->routeExists($currentRoute)) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }

        // Get the output function
        $currentRoute = $this->routes[$currentRoute];
        $output = $currentRoute->output;

        $callBackParams = $this->getParams($currentRoute, $currentUri);

        if ($callBackParams === null) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }

        $output($callBackParams, '');

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
        $urlParams = $this->splitToParams($uri);

        if (!in_array($uri, $this->routes)) {
            $route = new \stdClass();

            $route->name            = $uri;
            $route->output          = $output;
            $route->urlParams       = $urlParams;
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

    /**
     * Get the current route that is beeing accessed
     *
     * @return void
     */
    private function getCurrentRoute(): ?string
    {
        $currentUri = $this->urlHandler->getUriPath();

        // Route with url params or not
        $currentRoute = $this->urlHandler->routeWithUrlParams($currentUri, $this->routes);
        if (!$this->routes[$currentRoute]->urlParams) {
            $currentRoute = $currentUri;
        }

        return $currentRoute;
    }

    private function routeExists(string $currentRoute): bool
    {
        return array_key_exists($currentRoute, $this->routes);
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

    private function getParams($currentRoute, $currentUri, ?bool $overwriteArrayParams = false)
    {
        $urlParams = $currentRoute->urlParams;
        $params = $currentRoute->params;

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
