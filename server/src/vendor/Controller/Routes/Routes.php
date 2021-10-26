<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

use Aloefflerj\FedTheDog\Controller\Helpers\UrlHelper;

class Routes
{
    use UrlHelper;

    private static $current;
    // public $post;
    // public $put;
    // public $delete;
    // public $options;
    public static $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function __get($name)
    {
        return $this->routes[$name];
    }

    public function add()
    {
        $currentUri = self::$current->name;
        $currentVerb = self::$current->verb;

        if(!is_array($this->routes[$currentVerb])) {
            $this->routes[$currentVerb] = [];
        }

        if (!in_array($currentUri, $this->routes[$currentVerb])) {
            $this->routes[$currentVerb][$currentUri] = self::$current;
        }

        return $this->routes[$currentVerb][$currentUri] ? $this : null;
    }

    public function get(string $uri, \closure $output, ?array $functionParams)
    {
        self::$current = new Get($uri, $output, $functionParams);

        return $this;
    }

    public function post(string $route, \closure $output, ?array $functionParams)
    {
        self::$current = new Post($route, $output, $functionParams);

        return $this;
    }

    public function getCurrent($currentUri)
    {
        $currentRoute = null;

        $requestMethod = $this->getRequestMethod();

        switch ($requestMethod) {
            case 'get':
                $currentRoute = (Get::getRoute($currentUri, $this->routes, $requestMethod));
                break;
            
            default:
                echo "not get";
                break;
        } 

        return $currentRoute;

    }

    public function getRouteByName($name)
    {
        $requestMethod = $this->getRequestMethod();

        $currentRoute = $this->routes[$requestMethod][$name];

        return $currentRoute;
    }

    public function dispatchRoute($currentRoute)
    {

        $requestMethod = $this->getRequestMethod();

        return $this->routes[$requestMethod][$currentRoute->name]->dispatch();

    }
}
