<?php

function delete_group(int $group_id = 0): bool {
    global $db;

    $db->query("DELETE FROM `Groups` WHERE group_id = $group_id");

    if ($db->affected_rows > 0) return true; // Deletion successful
    else return false; // No rows were deleted
}

function delete_user(int $group_id = 0, string $user_iin = '') {
    global $db;

    $db->query("DELETE FROM `Group_Students` WHERE user_iin = '$user_iin' AND group_id = $group_id");

    if ($db->affected_rows > 0) return true; // Deletion successful
    else return false; // No rows were deleted

}