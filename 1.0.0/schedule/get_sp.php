<?php

function get_sp(string $code) {
    global $db;
    $user_info = $db->query("SELECT `sp_id`, `sp_name`, `sp_code`, `sp_edu_base`, `sp_department`, `sp_duration`, `sp_language` FROM Specializations WHERE `sp_code` = '$code'")->fetch_assoc();
    return ($user_info) ? $user_info : NULL;
}