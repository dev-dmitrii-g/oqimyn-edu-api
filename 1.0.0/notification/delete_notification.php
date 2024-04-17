<?php

function delete_notification(string $id) {
    global $db;
    return $db->query("DELETE FROM Notifications WHERE id = '$id'");
}