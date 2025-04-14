<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . "/inc/config.php";  // Include config.php for database credentials
require __DIR__ . "/inc/bootstrap.php";  // Your bootstrap file (if needed)

// Create DB connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Show error if connection fails
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);  // Get the URL path
$uri = explode('/', $uri);  // Split the path

// Check if the URI contains both 'endpoint' and 'action'
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

// The base folder for controllers (no namespace path, just the file path)
$prefix = $uri[2];  // 'animal' or 'user'
$className = ucfirst($prefix) . "Controller";  // AnimalController or UserController

// Check if the controller class exists
if (!class_exists($className)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

$controller = new $className();  // Instantiate the controller

// Get the action method from the URL
$strMethodName = $uri[3] . 'Action';  // readAction(), createAction(), etc.

// Check if the method exists in the controller
if (!method_exists($controller, $strMethodName)) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// Call the method dynamically
$controller->{$strMethodName}();
?>
