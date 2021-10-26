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

    /**
     * @param string $uri
     * @param \closure $output
     * @param array|null $functionParams
     */
    protected function __construct(string $uri, \closure $output, ?array $functionParams) {
        
        $this->name             = $uri;
        $this->output           = $output;
        $this->functionParams   = $functionParams;

        self::$urlHandler       = new UrlHandler();

    }

    /**
     * Get the request method name
     *
     * @param string $verb
     * @return string
     */
    protected function getVerbName(string $verb): string
    {
        $separatedClassName = explode('\\', $verb);
        $className = end($separatedClassName);

        return strtolower($className);
    }

}
