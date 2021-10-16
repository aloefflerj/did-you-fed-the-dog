<?php


include_once dirname(__DIR__, 1) . '/src/autoload.php';

use Aloefflerj\FedTheDog\Controller\UrlHandler;
use Aloefflerj\FedTheDog\Test\UserClass;


$user = new UserClass('Anderson');

echo $user->getName() . '<br>';

$urlHandler = new UrlHandler();

$urlHandler->processUrl();

// var_dump($_GET);