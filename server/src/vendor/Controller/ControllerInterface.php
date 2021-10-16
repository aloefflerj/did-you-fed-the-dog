<?php

namespace Aloefflerj\FedTheDog\Controller;

interface ControllerInterface
{
    function get();

    function post();

    function put();

    function patch();

    function delete();

    function dispatch();

}