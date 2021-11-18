<?php

use Dotenv\Dotenv;
use App\Core\Application;
use App\Controllers\WorkController;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$config = [
    'db' => [
        'dbHost' => $_ENV['DB_HOST'],
        'dbPort' => $_ENV['DB_PORT'],
        'dbName' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USERNAME'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];
$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [WorkController::class, 'index']);
$app->router->get('/work', [WorkController::class, 'index']);
$app->router->post('/work', [WorkController::class, 'store']);
$app->router->get('/work/calendar', [WorkController::class, 'showCalendar']);
$app->router->get('/work/create', [WorkController::class, 'create']);
$app->router->get('/work/:id/edit', [WorkController::class, 'edit']);
$app->router->post('/work/:id', [WorkController::class, 'update']);
$app->router->post('/work/:id/delete', [WorkController::class, 'delete']);

$app->run();