<?php

namespace Aloefflerj\FedTheDog\Controller;

trait UrlHelper
{
    public function breakUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}