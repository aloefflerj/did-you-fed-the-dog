<?php

namespace Aloefflerj\FedTheDog\Controller;

class BaseController implements ControllerInterface
{
    public function get()
    {
        echo "get";
    }

    public function post($body)
    {
        echo "<pre>", var_dump($body), "</pre>";
    }
}
