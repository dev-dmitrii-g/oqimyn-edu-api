<?php
function te_add(string $iin) {
    global $db;
    
    // Check if te_iin already exists in Teachers table
    $checkTeacherStmt = $db->prepare("SELECT 1 FROM Teachers WHERE te_iin = ?");
    $checkTeacherStmt->bind_param("s", $iin);
    $checkTeacherStmt->execute();
    $checkTeacherResult = $checkTeacherStmt->get_result();

    if ($checkTeacherResult->num_rows > 0) {
        return error("Учитель с указанным ИИН уже существует", 400);
    }

    $stmt = $db->prepare("INSERT INTO Teachers (te_iin)
        SELECT te_iin
        FROM (
            SELECT ? AS te_iin
        ) AS temp
        WHERE EXISTS (
            SELECT 1 FROM Users WHERE user_iin = temp.te_iin
        ) AND (
            SELECT user_role_id FROM Users WHERE user_iin = temp.te_iin
        ) > 1;
    ");
    $stmt->bind_param("s", $iin);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        return error("OK", 200);
    } else {
        // Check if te_iin exists in Users table
        $checkStmt = $db->prepare("SELECT 1 FROM Users WHERE user_iin = ?");
        $checkStmt->bind_param("s", $iin);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows === 0) {
            return error("Указанный ИИН не существует в базе данных", 400);
        } else {
            return error("У пользователя недостаточно прав для добавления в учителя", 400);
        }
    }
}
