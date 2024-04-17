<?php
// Данные БД
$host = "localhost";
$login = "root";
$password = "";
$db_name = "edu";

// Пытаемся подключится к БД
try {
    $db = mysqli_connect($host, $login, $password, $db_name);
    if (!$db) {
        throw new Exception("Error connecting to the database: " . mysqli_connect_error(), 500);
    }

// Ловим ошибку
} catch (Exception $exception) {
    echo "Error: " . $exception->getMessage();
}

?>