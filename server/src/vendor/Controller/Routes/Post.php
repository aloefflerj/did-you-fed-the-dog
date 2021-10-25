<?php

namespace Aloefflerj\FedTheDog\Controller\Routes;

class Post extends Route
{
    public function __construct(string $route, \closure $output, ?array $functionParams)
    {
        parent::__construct($route, $output, $functionParams);

        $this->verb =  parent::getVerbName(__CLASS__);
    }
}
