<?php

function search_sp(
    string $name = ""
): array {
    global $db;
    $user_info = $db->query("SELECT `sp_name`, `sp_code`, `sp_edu_base`, `sp_department`, `sp_duration`, `sp_language` FROM Specializations WHERE `sp_name` LIKE '%$name%'")->fetch_all(MYSQLI_ASSOC);
    return ($user_info) ? $user_info : [];
}