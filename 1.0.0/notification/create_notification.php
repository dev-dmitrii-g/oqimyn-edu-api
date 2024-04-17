<?php

/*
Takes in user's iin, notification title, notification text, notification type
Inserts this information into the database
Returns NULL
*/
function create_notification() {
    global $db; // Connecting to the database

    // 
    $send_type = $_POST["send_type"];
    $title = $_POST["title"];
    $text = $_POST["text"];
    $type = $_POST["type"];

    $check_type = $db->query("SELECT COUNT(*) as count FROM Notification_Types WHERE type = '$type'");
    $type_exists = $check_type->fetch_assoc()['count'];

    if ($type_exists === 0) {
        error("Неверный тип уведомления.", 400);
    }

        $stmt = $db->prepare("INSERT INTO `Notifications` (`send_type`, `title`, `text`, `type`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $send_type, $title, $text, $type);
        $stmt->execute();

        $notification_id = $stmt->insert_id;
        
        switch($send_type) {
            case "everyone":
                break;
            case "group":
                $group_id = $_POST["group_id"];

                $group_users = $db->query("SELECT `user_iin` FROM `Group_Students` WHERE `group_id` = '$group_id'");

                if ($group_users) {
                    while ($row = $group_users->fetch_assoc()) {
                        $user_iin = $row["user_iin"];

                        $db->query("INSERT INTO `Notification_Recieve` (`notification_id`, `user_iin`) VALUES ('$notification_id', '$user_iin')");
                    }
                }

                $group_users->free();
                break;
            case "user":
                $user_iin = $_POST["user_iin"];

                $db->query("INSERT INTO `Notification_Recieve` (`notification_id`, `user_iin`) VALUES ('$notification_id', '$user_iin')");
                break;
            case "teachers":
                
                $teachers = $db->query("SELECT `te_iin` FROM `Teachers`");

                if ($teachers) {
                    while ($row = $teachers->fetch_assoc()) {
                        $user_iin = $row["user_iin"];

                        $db->query("INSERT INTO `Notification_Recieve` (`notification_id`, `user_iin`) VALUES ('$notification_id', '$user_iin')");
                    }
                }
            }
        }