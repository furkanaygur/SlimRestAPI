<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../src/vendor/autoload.php';

$app = AppFactory::create();

$app->get('/comments', function (Request $request, Response $response) {

    $db = new Db();

    try {
        $db = $db->connect();
        $comments = $db->query('SELECT * FROM comments')->fetchAll(PDO::FETCH_OBJ);

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json')
            ->withJson($comments);
    } catch (PDOException $err) {
        return $response->withJson([
            'error' => [
                'message' => $err->getMessage(),
                'code' => $err->getCode()
            ]
        ]);
    }

    $db = null;
});
