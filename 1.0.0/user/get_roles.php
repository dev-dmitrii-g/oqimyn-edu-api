<?php

function get_roles() {
    global $db;
    return $db->query("SELECT * FROM Roles")->fetch_all(MYSQLI_ASSOC);
}