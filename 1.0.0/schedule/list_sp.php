<?php

// Assuming you have already connected to your database and $db is the database connection object

function list_sp() {
    global $db;
    $user_info = $db->query("SELECT `sp_name`, `sp_code`, `sp_edu_base`, `sp_department`, `sp_duration`, `sp_language` FROM Specializations")->fetch_all(MYSQLI_ASSOC);
    if ($user_info === false) {
        // Handle the error, such as logging it or returning NULL
        error_log("Error fetching data: " . $db->error);
        return NULL;
    }
    return ($user_info) ? $user_info : NULL;
}
