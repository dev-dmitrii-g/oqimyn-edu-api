<?php
// Подключаем файл database.php
include "./database.php";

// Создание токена
function create_token(string $user_login, string $user_password, string $token = NULL): string {
    return hash("sha256", $user_login . $user_password . date("Ymd") . $token);
}

// Проверка на существование токена
function is_token(string $token = ""): bool {
    global $db;
    $is_token = $db->query("SELECT `user_iin` FROM Users WHERE `user_access_token` = `$token`")->fetch_assoc();
    return ($is_token != NULL) ? true : false;
}