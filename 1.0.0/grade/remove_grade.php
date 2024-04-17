<?php

// Функция "Удалить оценку"
function remove_grade() {
    // Инициализируем датабазу
    global $db;

    // Принимаем параметры
    $token = $_POST["token"];
    $grade_id = $_POST["grade_id"];

    // Проверка на существование оценки
    $check_grade = $db->prepare("SELECT 1 FROM `Grades` WHERE g_id = ?");
    $check_grade->bind_param("i", $grade_id);
    $check_grade->execute();
    $check_grade_result = $check_grade->get_result();
    
    if ($check_grade_result->num_rows === 0) {
        return error("Данной оценки не существует.", 400);
    }

    // Подготавливаем SQL запрос
    $stmt = $db->prepare("DELETE FROM `Grades` WHERE g_id = ?");
    $stmt->bind_param("i", $grade_id);

    // Выполняем запрос
    $stmt->execute();

    // Проверка выполнения функции
    if ($stmt->affected_rows > 0) {
        return error("Оценка удалена!", 200);
    } else {
        return error("Произошла ошибка при удалении оценки.", 500);
    }
}
