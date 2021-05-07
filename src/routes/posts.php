<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../src/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/posts', function (Request $request, Response $response) {

    $db = new Db();

    try {
        $db = $db->connect();
        $response->getBody()->write('data');

        return $response;
    } catch (PDOException $err) {
        $response->getBody()->write($err->getMessage());

        return $response;
    }

    $db = null;
});
