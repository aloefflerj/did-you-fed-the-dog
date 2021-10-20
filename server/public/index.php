<?php


include_once dirname(__DIR__, 1) . '/src/autoload.php';

use Aloefflerj\FedTheDog\Controller\BaseController;
use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;
use Aloefflerj\FedTheDog\Test\UserClass;

// strpos("oi, eu sou o anderson", ",");
// $uri = new UrlHandler();

// echo $uri->getUriPath();

// $fp = fopen('php://output', 'w');
// fwrite($fp, 'Hello World');
// fclose($fp);

$app = new BaseController();

$app->get('/', function($req, $res) {
    // var_dump($req->id);
    echo $req->name;
}, ['id' => 1, 'name' => 'anderson']);

$app->get('/param/{id}/{name}', function($req, $res) {
    echo "id";
    // echo $req->id;
});

$app->get('/about', function() {
    echo 'about';
});

$app->dispatch();

if($app->error()) {
    echo $app->error()->getMessage();
}

/**
 * How I want it to be
 * $app = new Router();
 * 
 * $app->get('/', function(){
 *     echo "home";
 * }, ["id" => 1, "name" => "anderson"]);
 */