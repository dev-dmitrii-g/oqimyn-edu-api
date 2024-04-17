<?php

function search(string $iin) {
    global $db;

    $row = $db->query("SELECT user_id, user_iin, user_first_name, user_last_name, user_middle_name, user_birth_date, user_gender, user_email, user_phone_number, user_role_id, role_name FROM Users, Roles WHERE user_iin = '$iin'")->fetch_assoc();
    
    if (!$row) {
        return error("IIN not found: $iin", 400);
    }
    
    return $row;
}