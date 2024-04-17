<?php

function edit_sp(
    int $id, 
    string $name = NULL, 
    string $code = NULL, 
    string $edu_base = NULL, 
    string $department = NULL, 
    string $duration = NULL, 
    string $language = NULL
) {
    global $db;
    $set_values = [];

    // Check if the user exists in the database
    $check_query = $db->query("SELECT COUNT(*) as count FROM Specializations WHERE sp_id = '$id'");
    $row = $check_query->fetch_assoc();
    if ($row['count'] == 0) {
        error("Specialization not found", 400); // Return an error message
        return;
    }

    // Prepare the SET part of the SQL UPDATE statement
    if ($name !== null) {
        $set_values[] = "sp_name = '$name'";
    }
    if ($code !== null) {
        $set_values[] = "sp_code = '$code'";
    }
    if ($edu_base !== null) {
        $set_values[] = "sp_edu_base = '$edu_base'";
    }
    if ($department !== null) {
        $set_values[] = "sp_department = '$department'";
    }
    if ($duration !== null) {
        $set_values[] = "sp_duration = '$duration'";
    }
    if ($language !== null) {
        $set_values[] = "sp_language = '$language'";
    }

    // Update the user information in the database
    $set_clause = implode(", ", $set_values);
    $db->query("UPDATE Specializations SET $set_clause WHERE sp_id = '$id'");

    // Success message
    error("Specialization information updated successfully", 200);
}
