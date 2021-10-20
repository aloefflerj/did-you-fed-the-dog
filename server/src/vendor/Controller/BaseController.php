<?php

namespace Aloefflerj\FedTheDog\Controller;

use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;

class BaseController
// class BaseController implements ControllerInterface
{
    public array $routes;
    private array $data;
    private $urlHandler;
    private \Exception $error;

    public function __construct() {
        $this->urlHandler = new UrlHandler();
        $this->routes = [];
    }

    public function getRoutes()
    {
        var_dump($this->routes);
    }

    public function get($uri, \closure $output, $params)
    {
        // echo $this->urlHandler->getUriPath();
        // echo "uri => {$uri}, params =>" . print_r($params, true);
        // printf("\n");
        // $output;
        $this->addRoute($uri, $output, $params);
    }

    public function post($body)
    {
        echo "<pre>", var_dump($body), "</pre>";
    }
    
    public function put($body)
    {
        echo "<pre>", var_dump($body), "</pre>";
    }

    public function dispatch()
    {
        $currentUri = $this->urlHandler->getUriPath();
        
        if(!array_key_exists($currentUri, $this->routes)) {
            $this->error = new \Exception("Error 404", 404);
            return $this;
        }
        
        $callBack = $this->routes[$currentUri]->output;
        $callBack();

        return $this;
        
    }

    public function error() {
        return $this->error ?? null;
    }

    //helper functions
    private function addRoute($uri, \closure $output, $params) {
        if(!in_array($uri, $this->routes)) {
            $route = new \stdClass();

            $route->name    = $uri;
            $route->output  = $output;
            $route->params  = $params;
            
            $this->routes[$uri] = $route;
        }
    }
}
