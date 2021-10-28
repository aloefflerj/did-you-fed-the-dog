<?php


include_once dirname(__DIR__, 1) . '/src/autoload.php';

use Aloefflerj\FedTheDog\Controller\BaseController;
use Aloefflerj\FedTheDog\Controller\Http\Message;
use Aloefflerj\FedTheDog\Controller\Url\UrlHandler;
use Aloefflerj\FedTheDog\Test\UserClass;

// $fp = fopen('php://output', 'w');
// fwrite($fp, 'Hello World');
// fclose($fp);

header('Content-Type: application/json');

$users = [
    [
        'id' => 1,
        'name' => 'anderson',
        'pet' => 'rex'
    ],
    [
        'id' => 2,
        'name' => 'juarez',
        'pet' => 'fluffy'
    ]
];

$app = new BaseController();

$app->get('/', function ($req, $res, $params) {
    echo json_encode("Bem vindo, {$params->name}", JSON_PRETTY_PRINT);
}, ['name' => 'Anderson']);

$app->get('/users', function ($req, $res, $params) {
    
    echo json_encode($params->users, JSON_PRETTY_PRINT);

}, ['users' => $users]);

$app->get('/users/{id}', function($req, $res, $params) {

    $users = [
        [
            'id' => 1,
            'name' => 'anderson',
            'pet' => 'rex'
        ],
        [
            'id' => 2,
            'name' => 'juarez',
            'pet' => 'fluffy'
        ]
    ];
    
    foreach($users as $user) {
        if($user['id'] === (int)$params->id) {
            echo json_encode($user, JSON_PRETTY_PRINT);
        }
    }

});

$app->post('/users', function ($req, $res, $body, $params) {

    echo $body;
    
});

$app->get('/test', function($req, $res, $params) {
    $message = new Message();

    $message = $message->withProtocolVersion('1.4');
    
    $message = $message->withHeader('Content-Type', ['application/json', 'text/plain']);

    echo $message->getHeaderLine('Content-Type');

    $message = $message->withAddedHeader('foo', 'bar');
    echo '<pre>', var_dump($message->getHeaders()), '</pre>';
    
});

$app->dispatch();

if ($app->error()) {
    echo $app->error()->getMessage();
}
