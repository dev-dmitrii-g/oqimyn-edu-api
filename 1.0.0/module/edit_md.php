<? php

//*
// @param $token $string $токен пользователя
// @param $name $string $название модуля
// @param $year $string $год модуля
// @param $spec $string $специализация модуля
// 
// @return $NULL;
// */

function edit_md() {
    // Подключаем датабазу
    global $db;

    // Проверяем на передачу данных
    if (!isset($_POST["token"]) || (!isset($_POST["id"])) {
      error("Неверные данные!", 400);
      exit;
    }

    $token = $_POST["token"];
    $id = $_POST["id"];
    $name = $_POST["name"];
    $year = $_POST["year"];
    $spec = $_POST["spec"];

    $set_values = [];

    // Проверить существует ли модуль 
    $check_query = $db->query("SELECT COUNT(*) as count FROM Modules WHERE md_id = '$id'");
    $row = $check_query->fetch_assoc();
    if ($row['count'] == 0) {
        error("Module not found", 404); // Return an error message
        return;
    }

    // Prepare the SET part of the SQL UPDATE statement
    if ($name !== null) {
        $set_values[] = "md_name = '$name'";
    }
    if ($year !== null) {
        $set_values[] = "md_year = '$first_name'";
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
}
