<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;

class Route
{
    public $name;
    public $output;
    public $verb;
    public $verbParams;
    public $functionParams;
    public static $urlHandler;

    protected function __construct(string $uri, \closure $output, ?array $functionParams) {
        
        $this->name             = $uri;
        $this->output           = $output;
        $this->functionParams   = $functionParams;

        self::$urlHandler       = new UrlHandler();

    }

    protected function getVerbName($verb)
    {
        $separatedClassName = explode('\\', $verb);
        $className = end($separatedClassName);

        return strtolower($className);
    }

}
