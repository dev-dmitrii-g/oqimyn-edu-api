<?php

function get_user_info(string $token = "") {
    global $db;
    $user_info = $db->query("SELECT `user_iin`, `user_first_name`, `user_last_name`, IFNULL(`user_middle_name`, '') as `user_middle_name`, `user_birth_date`, `user_phone_number`, IFNULL(`user_email`, '') as `user_email`, `role_name`, `user_profile_picture` FROM Users, Roles WHERE `user_access_token` = '$token' AND `role_id` = user_role_id")->fetch_assoc();
    return ($user_info) ? $user_info : null;
}

function getAllUser() {
    global $db;
    $user_info = $db->query("SELECT `user_iin`, `user_first_name`, `user_last_name`, IFNULL(`user_middle_name`, '') as `user_middle_name`, `user_birth_date`, `user_phone_number`, IFNULL(`user_email`, '') as `user_email`, `user_gender`, `role_name` FROM Users LEFT JOIN Roles ON `role_id` = user_role_id")->fetch_all(MYSQLI_ASSOC);
    return ($user_info) ? $user_info : [];
}

function readFileInStorage(string $path = ''): void {
    // Открываем поток для чтения файла
    $handle = fopen($path, 'rb');
    // Получаем MIME-тип файла
    $fileInfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $fileInfo->file($path);
    // Закрываем поток
    fclose($handle);
    // Устанавливаем заголовок MIME-типа
    header('Content-Type: ' . $mimeType);
    //Отправляем файл клиенту
    readfile($path);
}

function getPhoto(string $img = '') {
    $folderName = "images/";
    if(file_exists($folderName.$img)) {
        readFileInStorage($folderName.$img);
    }

}
