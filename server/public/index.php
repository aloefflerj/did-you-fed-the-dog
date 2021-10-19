<?php


include_once dirname(__DIR__, 1) . '/src/autoload.php';

use Aloefflerj\FedTheDog\Controller\Uri\UriHandler;
use Aloefflerj\FedTheDog\Test\UserClass;

$uri = new UriHandler();

echo $uri->getUrlPath();