<?php

function edit_group(
    string $group_id, 
    string $group_name = null, 
    int $group_year = 0, 
    string $group_specialty = null, 
    string $group_mentor_iin = null, 
    string $group_department = null, 
    string $group_study_type = null
) {

    global $db;

    if(!$db->query("SELECT sp_code FROM `Specializations` WHERE sp_code = '$group_specialty'")->fetch_assoc()) return error('Speciality not found', 400);

    // Build the SQL update statement dynamically based on the provided parameters
    $sql = "UPDATE `Groups` SET ";
    $params = array();

    if ($group_name !== null) {
        $sql .= "group_name = ?, ";
        $params[] = &$group_name;
    }
    if ($group_year !== null) {
        $sql .= "group_year = ?, ";
        $params[] = &$group_year;
    }
    if ($group_specialty !== null) {
        $sql .= "group_specialty = ?, ";
        $params[] = &$group_specialty;
    }
    if ($group_mentor_iin !== null) {
        $sql .= "group_mentor_iin = ?, ";
        $params[] = &$group_mentor_iin;
    }
    if ($group_department !== null) {
        $sql .= "group_department = ?, ";
        $params[] = &$group_department;
    }
    if ($group_study_type !== null) {
        $sql .= "group_study_type = ?, ";
        $params[] = &$group_study_type;
    }

    // Remove the trailing comma and space from the SQL statement
    $sql = rtrim($sql, ', ');

    // Add the WHERE clause to specify which group to update
    $sql .= " WHERE group_id = ?";

    // Bind parameters to the placeholders in the prepared statement
    $types = str_repeat('s', count($params)) . 's';
    array_unshift($params, $types); // Add types string at the beginning
    $params[] = &$group_id; // Add group_id parameter
    $stmt = $db->prepare($sql);
    call_user_func_array(array($stmt, 'bind_param'), $params);

    // Execute the prepared statement
    $stmt->execute();

    // Check if the execution was successful
    if ($stmt->affected_rows > 0) {
        return error("Group successfully updated", 200);
    } else {
        return error("Failed to update group", 500); // Adjust error handling as needed
    }
}

function add_user(int $group_id = 0, string $user_iin = ''): bool {
    global $db;
    $db->query(
        "INSERT INTO `Group_Students` (`user_iin`, `group_id`)
        SELECT '$user_iin', $group_id
        FROM DUAL
        WHERE NOT EXISTS (
            SELECT 1
            FROM `Group_Students`
            WHERE user_iin = '$user_iin'
        ) AND EXISTS (
            SELECT 1
            FROM `Groups`, `Users`
            WHERE user_iin = '$user_iin' AND group_id = $group_id
        )");

    return ($db->affected_rows > 0) ? true : false;
}