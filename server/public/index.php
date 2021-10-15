<?php


include_once dirname(__DIR__, 1) . '/src/autoload.php';

use Aloefflerj\FedTheDog\Test\UserClass;


$user = new UserClass('Anderson');

echo $user->getName();

var_dump($_GET);