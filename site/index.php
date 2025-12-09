<?php
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    require "../config.local.php";
} else {
    require "../config.prod.php";
}

require "../connectDB.php";
//model
require "../bootstrap.php";
session_start();

$c              = $_GET["c"] ?? "home";
$a              = $_GET["a"] ?? "index";
$controllerName = ucfirst($c) . "Controller";
require "controller/" . $controllerName . ".php";
$controller = new $controllerName();
if (method_exists($controller, $a)) {
    $controller->$a();
} else {
    die("Action không tồn tại: $a");
}
