<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require '../src/vendor/autoload.php';
require '../src/config/db.php';

$app = AppFactory::create();

require '../src/config/router.php';

$app->run();
