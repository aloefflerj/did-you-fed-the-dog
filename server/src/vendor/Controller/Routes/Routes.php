<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

class Routes
{
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
        // $urlParams = $this->splitToParams($uri);

        // if (!in_array($uri, $this->routes)) {
        //     $route = new \stdClass();

        //     $route->name            = $uri;
        //     $route->output          = $output;
        //     // $route->urlParams       = $urlParams;
        //     // $route->verb            = $verb;
        //     $route->params          = $params;
        //     // $route->headersParamQty = $headerParamsQty ?? null;

        //     $this->routes[$uri] = $route;
        // }

        // return $this->routes[$uri] ? $this : null;
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
}
