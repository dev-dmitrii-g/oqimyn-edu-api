<?php

function search_group(string $group_name) {
    global $db;

    $row = $db->query("SELECT * FROM `Groups` WHERE group_name = '$group_name'")->fetch_assoc();
    if (!$row) {
        return error("Group not found: $group_name", 400);
    }

    return $row;
}

function search_groups(string $group_name) {
    global $db;

    $row = $db->query("SELECT * FROM `Groups` WHERE group_name LIKE '%$group_name%'")->fetch_all(MYSQLI_ASSOC);
    if (!$row) {
        return error("Group not found: $group_name", 400);
    }

    return $row;
}