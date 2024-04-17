<?php

// Функция "Добавить оценку"
function add_grade() {
    // Инициализируем датабазу
    global $db;
    // Принимаем параметры
    $user_iin = $_POST["user_iin"];
    $grade = $_POST["grade"];
    $task_id = $_POST["task_id"];
    $date = $_POST["date"];
    
    // Проверка на корректность оценки
    if ($grade > 100) {
        return error("Оценка не может быть выше 100 баллов.", 400);
    }

    // // Проверка на существование задания (НЕ РАБОТАЕТ)
    // $check_task = $db->prepare("SELECT 1 FROM Tasks WHERE task_id = ?");
    // $check_task->bind_param("i", $task_id);
    // $check_task->execute();
    // $check_task_result = $check_task->get_result();

    // if ($check_task_result->num_rows === 0) {
    //     return error("Данного задания не существует.", 400);
    // }

    // Подготавливаем SQL запрос
    $stmt = $db->prepare("INSERT INTO `Grades` (g_user_iin, g_grade, g_task_id, g_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siis", $user_iin, $grade, $task_id, $date);

    // Выполняем запрос
    $stmt->execute();

    // Проверка выполнения функции
    if ($stmt->affected_rows > 0) {
        return error("Оценка добавлена!", 200);
    } else {
        return error("Произошла ошибка при добавлении оценки.", 500);
    }
}
