<?php

function delete_sp(
    string $code
) {
    global $db;
    return $db->query("DELETE FROM Notifications WHERE sp_code = '$code'");
}