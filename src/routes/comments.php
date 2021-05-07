<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../src/vendor/autoload.php';
include '../api/script.php';
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

$app->get('/comments/add', function (Request $request, Response $response) {

    $db = new Db();
    try {
        $db = $db->connect();
        $query = $db->prepare('INSERT INTO comments (id, postId, name, email, body) VALUES (:id, :postId, :name, :email, :body) ');

        $comments = getComments();
        foreach ($comments as $key => $value) {
            if($value['id'] == 1) continue;
            $query->bindParam('id', $value['id']);
            $query->bindParam('postId', $value['postId']);
            $query->bindParam('name', $value['name']);
            $query->bindParam('email', $value['email']);
            $query->bindParam('body', $value['body']);
            $query->execute();
        }
    
        return $response->withStatus(200)->withJson([
            'message' => 'Datas added.'
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

 
