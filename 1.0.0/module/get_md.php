<?php

// Просмотреть все доступные модули
function list_all_accessable($iin) {
    global $db;

    return $db->query("SELECT Modules.md_name, Modules.md_year, Modules.md_specialization 
    FROM `Module_Access` 
    INNER JOIN `Modules` ON Module_Access.ma_md_id = Modules.md_id 
    WHERE Module_Access.ma_user_iin = '$iin'
    ")->fetch_all(MYSQLI_ASSOC);
}

// Просмотреть все модули
function list_all_modules() {
    // Подключаем Базу Данных
    global $db;

    // Берем токен для проверки доступа к функции
    if (!isset($_POST["token"])) {
        error("Введены неправильные данные!", 400);
        exit;
    }
    
    $token = $_POST["token"];  

    // Проверяем права
    $is_allowed = $db->query("SELECT `user_role_id`, `user_iin` FROM `Users` WHERE `user_access_token` = '$token'")->fetch_assoc();

    // Только завуч может просмотреть все модули
    if ($is_allowed["user_role_id"] === "3") {
      return $db->query("SELECT `md_name`, `md_year`, `md_specialization` FROM `Modules`")->fetch_all(MYSQLI_ASSOC);
    }

    return list_all_accessable($is_allowed["user_iin"]);

}
