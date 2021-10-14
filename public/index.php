<?php


include_once dirname(__DIR__, 1) . '/src/autoload.php';

use Aloefflerj\FedTheDog\UserClass;


$user = new UserClass('Anderson');

echo $user->getName();