<?php

function get_notification() {
    global $db;
    
    $token = $_POST["token"];

    // Получаем ИИН по токену
    $user_iin_result = $db->query("SELECT `user_iin` FROM Users WHERE `user_access_token` = '$token'");
    $user_iin_row = $user_iin_result->fetch_assoc();
    $user_iin = $user_iin_row['user_iin'];

    // Получаем все идентификаторы уведомлений для пользователя
    $notification_ids_result = $db->query("SELECT `notification_id` FROM `Notification_Recieve` WHERE `user_iin` = $user_iin");

    // Проходим через все уведомления и отправляем их в массив
    $notifications = [];
    while ($notification_id_row = $notification_ids_result->fetch_assoc()) {
        $notification_id = $notification_id_row['notification_id'];

        // Получаем данные об уведомлении
        $notification_result = $db->query("SELECT `title`, `text`, `type` FROM `Notifications` WHERE `id` = '$notification_id'");
        $notification = $notification_result->fetch_assoc();

        // Добавляем в массив
        $notifications[] = $notification;
    }

    return $notifications;
}

function get_everyone_notification() {
    global $db;
    return $db->query("SELECT `title`, `text`, `type` FROM `Notifications` WHERE `send_type` = 'everyone'")->fetch_all(MYSQLI_ASSOC);
}

