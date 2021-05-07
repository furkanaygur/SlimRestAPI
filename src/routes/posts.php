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
        $posts = $db->query('SELECT * FROM posts')->fetchAll(PDO::FETCH_OBJ);

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json')
            ->withJson($posts);
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

$app->get('/posts/{id}/comments', function (Request $request, Response $response) {

    $id = $request->getAttribute('id');
    $db = new Db();
    try {
        $db = $db->connect();
        $query = $db->prepare('SELECT comments.id, comments.name, comments.email, comments.body 
        FROM posts JOIN comments on comments.postId = posts.id WHERE posts.id = :id');
        $query->execute([
            'id' => $id
        ]);
        $posts = $query->fetchAll(PDO::FETCH_OBJ);
        if ($posts) {
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json')
                ->withJson($posts);
        }

        return $response->withStatus(404)->withJson([
            'error' => [
                'code' => 404,
                'message' => 'Not Found!'
            ]
        ]);
    } catch (PDOException $err) {
        return $response->withJson([
            'error' => [
                'code' => $err->getCode(),
                'message' => $err->getMessage()
            ]
        ]);
    }

    $db = null;
});
