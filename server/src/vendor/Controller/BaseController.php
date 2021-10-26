<?php

namespace Aloefflerj\FedTheDog\Controller;

use Aloefflerj\FedTheDog\Controller\Helpers\StringHelper;
use Aloefflerj\FedTheDog\Controller\Helpers\UrlHelper;
use Aloefflerj\FedTheDog\Controller\Routes\Routes;
use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;

class BaseController
// class BaseController implements ControllerInterface
{
    use StringHelper;
    use UrlHelper;
    /**
     * Group all routes
     *
     * @var Routes $routes
     */
    public Routes $routes;

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
        $this->routes = new Routes();
    }

    /**
     * Get http verb route add
     *
     * @param string $uri
     * @param \closure $output
     * @param array|null $params
     * @return BaseController
     */
    public function get(string $uri, \closure $output, ?array $functionParams = null): BaseController
    {
        $routes = $this->routes->get($uri, $output, $functionParams)->add();
        if($routes->error()) {
            $this->error = $routes->error();
        }
        return $this;
    }

    public function post(string $uri, \closure $output, ?array $functionParams = null): BaseController
    {
        $routes = $this->routes->post($uri, $output, $functionParams)->add();
        if($routes->error()) {
            $this->error = $routes->error();
        }
        return $this;
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
        // Check if there is an error before dispatch
        if($this->error()) {
            echo $this->error()->getMessage();
            die();
        }

        $currentRouteName = $this->getCurrentRouteName();

        // Check if it is mapped
        if (!$this->routeExists($currentRouteName)) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }

        $currentRoute = $this->routes->getRouteByName($currentRouteName);

        $this->routes->dispatchRoute($currentRoute);

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
     * getRoutes
     *
     * @return array|null
     */
    public function getRoutes(): ?Routes
    {
        return $this->routes ?? null;
    }

    /**
     * Get the current route that is beeing accessed
     *
     * @return void
     */
    private function getCurrentRouteName(): ?string
    {
        $currentUri = $this->urlHandler->getUriPath();

        $currentRoute = $this->routes->getCurrent($currentUri);
        
        return $currentRoute;
    }

    private function routeExists(string $currentRoute): bool
    {
        $requestMethod = $this->getRequestMethod();
        return array_key_exists($currentRoute, $this->routes->$requestMethod);
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
        $urlParams = $currentRoute->verbParams;
        $params = $currentRoute->functionParams;

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

    /**
     * ||================================================================||
     *                          TEST FUNCTIONS
     * ||================================================================||
     */

}
