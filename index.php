<?php
// Подключение файлов
include "module/token.php";
include "module/response.php";
include "module/config.php";

// Подключение заголовков
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 172800"); // кэш на 2 дня
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Проверка на разрешенность заголовков
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit;
};

// Разделяем URL
$router = explode("/", $_SERVER["REQUEST_URI"]);
$router = array_splice($router, 1);

// Информация по headers, IP, API
$headers = getallheaders();
$api_version = (string) $router[0];
$x_real_ip = $headers["X-Real-IP"];

// Проверка версии API
if (!check_api_version($api_version))
    error("Incorrect API version", 404);

include $api_version."/index.php";
?>
