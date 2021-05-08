<?php

use Slim\Factory\AppFactory;

require '../src/vendor/autoload.php';
require '../src/config/db.php';

$app = AppFactory::create();

require '../src/config/router.php';

$app->run();
