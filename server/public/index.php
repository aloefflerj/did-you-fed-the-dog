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

// $rawData = file_get_contents('php://input');
// var_dump($rawData);
// die();

$app = new BaseController();

// $app->routesTesting('/routes', function($req, $res) {
//     echo 'olá';
// }, ["id" => 1]);

// $app->routesTesting('/routes/{id}', function($req, $res) {
//     echo 'olá';
// });

// $app->get('/home', function ($req, $res) {
//     echo 'bem vindo';
// }, ['id' => 1]);

// $app->get('/home/{id}', function ($req, $res) {
//     echo 'bem vindo';
// });

// $app->post('/home', function ($req, $res) {
//     echo 'bem vindo';
// }, ['id' => 1]);


// echo '<pre>', var_dump($app->getRoutes()), '</pre>';

// return;


$app->get('/', function ($req, $res) {
    echo 'home';
    // echo $req->name;
}, ['id' => 1, 'name' => 'anderson']);

// $app->get('/param/{id}', function ($req, $res) {
//     echo "id = {$req->id} | name = {$req->name}";// => TRATAR ESSE ERRO
// });

$app->get('/param/{id}/{name}', function ($req, $res) {
    echo "id = {$req->id} | name = {$req->name}";
});

$app->get('/about', function () {
    echo 'about';
});

$app->post('/post/{id}', function ($req, $res, $body) {
    echo "post route {$req->id}";
    echo '<pre>', var_dump($body), '</pre>';
});
// $app->get('/post/{id}', function ($req, $res) {
//     echo "post route {$req->id}";
//     // echo '<pre>', var_dump($body), '</pre>';
// });


$app->dispatch();

if ($app->error()) {
    echo $app->error()->getMessage();
}
