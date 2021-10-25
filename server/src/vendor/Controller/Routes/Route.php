<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

class Route
{
    public $name;
    public $output;
    public $verb;
    public $verbParams;
    public $functionParams;

    protected function __construct(string $uri, \closure $output, ?array $functionParams) {
        
        $this->name             = $uri;
        $this->output           = $output;
        $this->functionParams   = $functionParams;

    }

    protected function getVerbName($verb)
    {
        $separatedClassName = explode('\\', $verb);
        $className = end($separatedClassName);

        return strtolower($className);
    }

    // protected static function add($uri, \closure $output, string $verb, ?array $params)
    // {
    //     // $urlParams = $this->splitToParams($uri);

    //     // if (!in_array($uri, $this->routes)) {
    //         // $route = new \stdClass();

    //         // $route->name            = $uri;
    //         // $route->output          = $output;
    //         // $route->urlParams       = $urlParams;
    //         // $route->verb            = $verb;
    //         // $route->params          = $params;
    //         // $route->headersParamQty = $headerParamsQty ?? null;

    //         // $this->routes[$uri] = $route;
    //     // }

    //     // return $this->routes[$uri] ? $this : null;
    // }
}
