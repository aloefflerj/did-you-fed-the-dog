<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

class Get extends Route
{
    public function __construct(string $uri, \closure $output, ?array $functionParams)
    {
        parent::__construct($uri, $output, $functionParams);

        $this->verb         =  parent::getVerbName(__CLASS__);
        $this->verbParams   = $this->splitToParams($uri);
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
}