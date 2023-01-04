<?php declare(strict_types=1);

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

include '../vendor/autoload.php';

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Api\Providers\DbConnection;

include '../src/Providers/EnvManager.php';

$connectionArgs = [
    "host"     => $_ENV['DB_HOST'],
    "user"     => $_ENV['DB_USER'],
    "password" => $_ENV['DB_PASSWORD'],
    "database" => $_ENV['DB_NAME'],
];

try {
    $connection = new DbConnection($connectionArgs);
    $connection->testConnection();
} catch (PDOException $error) {
    http_response_code(503);
    die(json_encode([
       'OK' => false,
       'code' => 'DATABASE_NOT_CONNECTING',
       'message' => "Database not connecting",
       'details' => $error->getMessage(),
    ]));
}

$request = ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = require '../src/Routes/web.php';
$response = $router->dispatch($request);

(new SapiEmitter)->emit($response);
