<?php


function get_users(int $groupId = 0) {
    global $db;

    return $db->query("SELECT `user_first_name`, `user_last_name`, IFNULL(`user_middle_name`, '') as `user_middle_name`, Users.user_iin FROM `Group_Students`, `Users` WHERE Group_Students.group_id = $groupId AND Users.user_iin = Group_Students.user_iin")->fetch_all(MYSQLI_ASSOC);
}

function get_groups(): array {
    global $db;
    $groups = $db->query('SELECT * FROM `Groups`')->fetch_all(MYSQLI_ASSOC);
    return ($groups) ? $groups : [];
}