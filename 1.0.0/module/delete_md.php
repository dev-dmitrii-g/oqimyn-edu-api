<?php

function delete_md(string $name) {
    global $db;
    return $db->query("DELETE FROM `Modules` WHERE md_name = '$name'");
}