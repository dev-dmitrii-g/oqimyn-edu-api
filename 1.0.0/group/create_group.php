<?php

function create_group(
    string $group_name, 
    int $group_year, 
    string $group_specialty, 
    string $group_mentor_iin, 
    string $group_department, 
    string $group_study_type
) {

    global $db;

    if($group_year > 2155) return error("Year out of range", 400);

    $db->query("SELECT sp_code FROM Specializations WHERE sp_code = '$group_specialty'")->fetch_assoc();

    if($db->affected_rows > 0) {
        // Prepare the SQL statement with placeholders
        $stmt = $db->prepare("INSERT INTO `Groups` (`group_name`, `group_year`, `group_specialty`, `group_mentor_iin`, `group_department`, `group_study_type`) VALUES (?, ?, ?, ?, ?, ?)");

        // Bind parameters to the placeholders in the prepared statement
        $stmt->bind_param("ssssss", $group_name, $group_year, $group_specialty, $group_mentor_iin, $group_department, $group_study_type);

        // Execute the prepared statement
        $stmt->execute();

        // Check if the execution was successful
        if ($stmt->affected_rows > 0) {
            return error("Группа успешно создана", 200);
        } else {
            return error("Failed to add group", 500); // Adjust error handling as needed
        }
    }
    return error("Speciality not found", 400);
}
