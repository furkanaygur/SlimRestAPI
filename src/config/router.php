<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require '../src/vendor/autoload.php';

$_url = parse_url($_SERVER['REQUEST_URI']);
$_routes = explode('/', $_url['path']);
$_baseRoute = $_routes[1];
switch ($_baseRoute) {
    case 'posts':
        require '../src/routes/posts.php';
        break;
    case 'comments':
        require '../src/routes/comments.php';
        break;
    default:
        if ($_baseRoute) {
            $app->get('/' . $_baseRoute, function (Request $request, Response $response) {
                return $response->withJson([
                    'error' => [
                        'code' => 400,
                        'message' => 'Bad Request',
                    ]
                ]);
            });
        }

        $app->get('/', function (Request $request, Response $response) {
            return $response->withJson([
                'pages' => [
                    'posts' => $_SERVER['HTTP_HOST'] . '/posts',
                    'comments' => $_SERVER['HTTP_HOST'] . '/comments',
                    'comments of post' => $_SERVER['HTTP_HOST'] . 'posts/{post_id}/comments',
                ]
            ]);
        });

        break;
}
