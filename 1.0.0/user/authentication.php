<?php

// Функция для авторизации
function authentication() {
    global $db;

    if (!isset($_POST["login"]) || !isset($_POST["password"]) || $_POST["password"] === '') {
        error("Bad request", 400);
        return null;
    }

    $login = $db->real_escape_string(trim($_POST["login"])); // Use real_escape_string to prevent SQL injection
    $password = hash("sha256", $_POST["password"]);

    // Use prepared statements to prevent SQL injection
    $stmt = $db->prepare("SELECT `user_iin`, `user_password` FROM Users WHERE `user_iin` = ? AND `user_password` = ?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user_auth = $result->fetch_assoc();
        return $user_auth;
    } else {
        return null;
    }
};


function registration(
    string $iin, 
    string $password, 
    string $first_name, 
    string $last_name, 
    string $middle_name, 
    string $birth_date, 
    string $gender, 
    string $phone_number
) {
    global $db;
    $password = hash("sha256", $password);

    // Check if the IIN already exists in the database
    $check_query = $db->query("SELECT COUNT(*) as count FROM Users WHERE user_iin = '$iin'");
    $row = $check_query->fetch_assoc();
    if ($row['count'] > 0) {
        error("IIN already exists", 400); // Return an error message
        return;
    }

    // Insert the new user into the database
    $db->query("INSERT INTO Users (user_iin, user_password, user_first_name, user_last_name, user_middle_name, user_birth_date, user_gender, user_phone_number) 
          VALUES ('$iin', '$password', '$first_name', '$last_name', NULLIF('$middle_name', ''), '$birth_date', '$gender', '$phone_number')");


    // Success message
    error("Registration successful", 200);
}

function edit(
    int $id, 
    string $iin = null, 
    string $password = null, 
    string $first_name = null, 
    string $last_name = null, 
    string $middle_name = null, 
    string $birth_date = null, 
    string $gender = null, 
    string $phone_number = null, 
    int $role_id = 0
) {
    global $db;
    $set_values = [];

    // Check if the user exists in the database
    $check_query = $db->query("SELECT COUNT(*) as count FROM Users WHERE user_id = '$id'");
    $row = $check_query->fetch_assoc();
    if ($row['count'] == 0) {
        error("User not found", 404); // Return an error message
        return;
    }

    // Prepare the SET part of the SQL UPDATE statement
    if ($iin !== null) {
        $set_values[] = "user_iin = '$iin'";
    }
    if ($password !== null) {
            if ($password === '') {
                return error("Password cannot be empty", 400);
            }
        $password = hash("sha256", $password);
        $set_values[] = "user_password = '$password'";
    }
    if ($first_name !== null) {
        $set_values[] = "user_first_name = '$first_name'";
    }
    if ($last_name !== null) {
        $set_values[] = "user_last_name = '$last_name'";
    }
    if ($middle_name !== null) {
        $set_values[] = "user_middle_name = NULLIF('$middle_name', '')";
    }
    if ($birth_date !== null) {
        $set_values[] = "user_birth_date = '$birth_date'";
    }
    if ($gender !== null) {
        $set_values[] = "user_gender = '$gender'";
    }
    if ($phone_number !== null) {
        $set_values[] = "user_phone_number = '$phone_number'";
    }
    if ($role_id !== null) {
        $set_values[] = "user_role_id = $role_id";
    }

    // Update the user information in the database
    $set_clause = implode(", ", $set_values);
    $db->query("UPDATE Users SET $set_clause WHERE user_id = '$id'");
    
    // Success message
    error("User information updated successfully", 200);
}

// Установить токен / Set token
function set_token(string $iin, string $token = ""): void {
    global $db;
    $db->query("UPDATE `Users` SET `user_access_token` = '$token' WHERE `user_iin` = '$iin'");
};
