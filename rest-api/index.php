<?php
require __DIR__ . "/inc/bootstrap.php";
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if (!isset($uri[2]) || !isset($uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/AnimalController.php";


$base = "Controller";
$prefix = $uri[2];
$className = $prefix . $base;

$controller = new $className();

$strMethodName = $uri[3] . 'Action';
$controller->{$strMethodName}();
?>