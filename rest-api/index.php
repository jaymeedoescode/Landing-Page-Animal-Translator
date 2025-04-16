<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . "/inc/bootstrap.php";  // Your bootstrap file (if needed)

// Create DB connection
$config = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

// Check connection
if ($config->connect_error) {
    die("Connection failed: .5" . $config->connect_error); // Show error if connection fails
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);  // Get the URL path
$uri = explode('/', $uri);  // Split the path

// Check if the URI contains both 'endpoint' and 'action'
if (!isset($uri[3]) && !isset($uri[4])) {
    header("HTTP/1.1 404 Not Found1");
    exit();
}




if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";
require PROJECT_ROOT_PATH . "/Controller/Api/AnimalController.php";



// The base folder for controllers (no namespace path, just the file path)
$prefix = $uri[3];  // 'animal' or 'user'
$className = $prefix . "Controller";  // AnimalController or UserController

// Check if the controller class exists
if (!class_exists($className)) {
    header("HTTP/1.1 404 Not Found2");
    exit();
}

$controller = new $className();  // Instantiate the controller

// Get the action method from the URL
$strMethodName = $uri[4] . 'Action';  // readAction(), createAction(), etc.

// Check if the method exists in the controller
if (!method_exists($controller, $strMethodName)) {
    header("HTTP/1.1 404 Not Found3");
    exit();
}

// Call the method dynamically
$controller->{$strMethodName}();
?>
