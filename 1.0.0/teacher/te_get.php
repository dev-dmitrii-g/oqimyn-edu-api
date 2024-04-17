<?php
function te_get($iin) {
    global $db;
    
    $result = $db->query("SELECT Users.user_iin, Users.user_first_name, Users.user_last_name, IFNULL(Users.user_middle_name, '') AS user_middle_name FROM Users INNER JOIN Teachers ON Teachers.te_iin = Users.user_iin WHERE Teachers.te_iin = '$iin'");
    
    if (!$result) {
        error("Невозможно получить данные", 400);
    }

    $row = $result->fetch_assoc();
    
    if (!$row) {
        error("ИИН не найден", 400);
    }

    return $row;
}