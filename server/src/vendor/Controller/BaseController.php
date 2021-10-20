<?php

namespace Aloefflerj\FedTheDog\Controller;

use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;

class BaseController
// class BaseController implements ControllerInterface
{
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
    public function dispatch(): BaseController
    {
        $currentUri = $this->urlHandler->getUriPath();

        if (!array_key_exists($currentUri, $this->routes)) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }

        $callBack = $this->routes[$currentUri]->output;
        $callBack();

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

    private function addRoute(string $uri, \closure $output, array $params)
    {
        if (!in_array($uri, $this->routes)) {
            $route = new \stdClass();

            $route->name    = $uri;
            $route->output  = $output;
            $route->params  = $params;

            $this->routes[$uri] = $route;
        }
    }

    public function getRoutes()
    {
        return $this->routes ?? null;
    }
}
