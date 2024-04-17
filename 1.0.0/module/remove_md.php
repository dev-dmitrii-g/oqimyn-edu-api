<?php

function delete_md() {
    // Подключаем базу данных
    global $db;

    // Проверка на права
    if (!isset($_POST["token"]) && !isset($_POST["name"])) {
        error("Введены неправильные данные!", 400);
        exit;
    }

    $token = $_POST["token"];
    $name = $_POST["name"];

    $is_allowed = $db->query("SELECT `user_role_id` FROM `Users` WHERE `user_access_token` = '$token'")->fetch_assoc();
    // Только завуч может просмотреть все модули
    if ($is_allowed["user_role_id"] != "3") {
        error("Доступ запрещен!", 400);
        exit;
    }

    return $db->query("DELETE FROM `Modules` WHERE md_name = '$name'");
}