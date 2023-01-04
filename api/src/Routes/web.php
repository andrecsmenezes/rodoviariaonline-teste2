<?php

use League\Route\Router;
use Laminas\Diactoros\ResponseFactory;
use League\Route\Strategy\JsonStrategy;
use Api\Middlewares\AuthMiddleware;
use Api\Middlewares\Dto\LoginDto;

$responseFactory = new ResponseFactory();
$strategy        = new JsonStrategy($responseFactory);
$router          = (new Router)->setStrategy($strategy);
$publicKey       = getenv('JWT_PUBLIC_KEY');
$authMiddleware  = new AuthMiddleware($publicKey);
$loginDto        = new LoginDto();

$router->map('GET',  '/',       'Api\Controllers\Hello\HelloController::index')
    ->middleware($authMiddleware);

$router->map('GET',  '/status', 'Api\Controllers\Hello\HelloController::status');

$router->map('POST', '/login',  'Api\Controllers\Auth\AuthController::login')
    ->middleware($loginDto);

$router->map('POST', '/logout', 'Api\Controllers\Auth\AuthController::logout')
    ->middleware($authMiddleware);

$router->map('GET', '/migrate',          'Api\Controllers\Migration\MigrationController::migrate');
$router->map('GET', '/migration-status', 'Api\Controllers\Migration\MigrationController::migrationStatus');

return $router;
