<?
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: *");
// header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

define('ROOT_DIR', __DIR__);

use Core\Router;

require './vendor/autoload.php';

try {
    $router = new Router();
    $router->start();
} catch (\Exception $e) {
    http_response_code($e->getCode());
    $result["status"] = $e->getMessage();
    echo json_encode($result, JSON_PRETTY_PRINT);
    http_response_code($e->getCode());
}
