<?php

function search_module(string $md_name) {
    global $db;
    return $db->query("SELECT * FROM `Modules` WHERE md_name LIKE '%$md_name%'")->fetch_all(MYSQLI_ASSOC);
}